// Constants
const CONFIG = {
    VALID_EXTENSIONS: [
        "jpg",
        "gif",
        "png",
        "jpeg",
        "JPG",
        "PNG",
        "JPEG",
        "Png",
        "GIF",
    ],
    MAX_FILE_SIZE: 5 * 1024 * 1024, // 5MB
    IMAGE_WIDTH: 360,
    IMAGE_HEIGHT: 205,
    DEFAULT_IMAGE: "/images/no-image-available.jpg",
    TOAST_DURATION: 5000,
};

// Toast Notification System
class ToastSystem {
    constructor() {
        this.container = this.createContainer();
        this.types = {
            success: "bg-green-600 border-green-800",
            error: "bg-red-600 border-red-800",
            warning: "bg-yellow-600 border-yellow-800",
            info: "bg-blue-600 border-blue-800",
        };
    }

    createContainer() {
        let container = document.querySelector("#toast-container");
        if (!container) {
            container = document.createElement("div");
            container.id = "toast-container";
            container.className =
                "fixed top-10 right-5 flex flex-col gap-3 z-50";
            document.body.appendChild(container);
        }
        return container;
    }

    show(message, type = "success") {
        const toast = document.createElement("div");
        toast.className = `fixed top-4 right-4 ${this.types[type]} text-white mt-8 p-4 rounded-lg shadow-lg transform transition-transform duration-500 border-l-4`;
        toast.style.transform = "translateX(100%)";
        toast.style.zIndex = "1000";

        const toastContent = document.createElement("div");
        toastContent.className = "flex items-center";

        const icon = document.createElement("i");
        icon.className = `fas ${this.getIconClass(type)} mr-3 text-xl`;

        const messageDiv = document.createElement("div");
        messageDiv.textContent = message;

        toastContent.appendChild(icon);
        toastContent.appendChild(messageDiv);
        toast.appendChild(toastContent);
        this.container.appendChild(toast);

        requestAnimationFrame(() => {
            toast.style.transform = "translateX(0)";
        });

        setTimeout(() => this.remove(toast), CONFIG.TOAST_DURATION);
    }

    remove(toast) {
        toast.style.transform = "translateX(100%)";
        setTimeout(() => {
            if (toast.parentElement) {
                toast.parentElement.removeChild(toast);
            }
        }, 500);
    }

    getIconClass(type) {
        switch (type) {
            case "success":
                return "fa-check-circle";
            case "error":
                return "fa-exclamation-circle";
            case "warning":
                return "fa-exclamation-triangle";
            default:
                return "fa-info-circle";
        }
    }
}

// Modal System
class ModalSystem {
    constructor() {
        this.setupModal();
    }

    setupModal() {
        // Create modal if it doesn't exist
        if (!document.getElementById("validationModal")) {
            const modalHTML = `
                <!-- Modal Template -->
                <div id="validationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                    <div class="bg-white rounded-lg p-6 max-w-sm mx-auto flex flex-col items-center">
                        <!-- Info Icon -->
                        <div class="w-16 h-16 rounded-full border-2 border-blue-400 flex items-center justify-center mb-4">
                            <span class="text-blue-400 text-4xl">i</span>
                        </div>

                        <!-- Message -->
                        <p class="text-gray-700 text-center mb-4" id="modalMessage">Hình ảnh không hợp lệ</p>

                        <!-- Button -->
                        <button onclick="modalSystem.close()" class="bg-blue-500 text-white px-8 py-2 rounded-md hover:bg-blue-600">
                            Đồng ý
                        </button>
                    </div>
                </div>
            `;
            document.body.insertAdjacentHTML("beforeend", modalHTML);
        }
    }

    show(message) {
        const modal = document.getElementById("validationModal");
        const messageEl = document.getElementById("modalMessage");
        messageEl.textContent = message;
        modal.classList.remove("hidden");
        modal.classList.add("flex");
    }

    close() {
        const modal = document.getElementById("validationModal");
        modal.classList.add("hidden");
        modal.classList.remove("flex");
    }
}

// Khởi tạo modalSystem
const modalSystem = new ModalSystem();

// Image Handler
class ImageHandler {
    constructor() {
        this.toastSystem = new ToastSystem();
        this.modalSystem = new ModalSystem();
        this.setupEventListeners();
    }

    setupEventListeners() {
        // File input change event
        const imageInput = document.getElementById("image");
        if (imageInput) {
            imageInput.addEventListener("change", (e) =>
                this.handleFileSelection(e)
            );
        }

        // Drag and drop events
        const dropArea = document.querySelector(".bg-gray-100");
        if (dropArea) {
            dropArea.addEventListener("dragover", (e) =>
                this.handleDragOver(e)
            );
            dropArea.addEventListener("dragleave", (e) =>
                this.handleDragLeave(e)
            );
            dropArea.addEventListener("drop", (e) => this.handleDrop(e));
        }

        // Set default image on load
        window.addEventListener("load", () => this.setDefaultImage());
    }

    async handleFileSelection(event) {
        const file = event.target.files[0];
        if (!file) {
            this.setDefaultImage();
            return;
        }

        const isValid = await this.validateImage(file);
        if (isValid) {
            this.previewFile(file);
        } else {
            event.target.value = "";
            this.setDefaultImage();
        }
    }

    handleDragOver(event) {
        event.preventDefault();
        event.currentTarget.classList.add("bg-gray-300");
    }

    handleDragLeave(event) {
        event.currentTarget.classList.remove("bg-gray-300");
    }

    handleDrop(event) {
        event.preventDefault();
        const dropArea = event.currentTarget;
        dropArea.classList.remove("bg-gray-300");

        const files = event.dataTransfer.files;
        if (files.length > 0) {
            const imageInput = document.getElementById("image");
            imageInput.files = files;
            this.handleFileSelection({ target: { files: files } });
        }
    }

    async validateImage(file) {
        try {
            // Check file type
            const extension = file.name.split(".").pop().toLowerCase();
            if (!CONFIG.VALID_EXTENSIONS.includes(extension)) {
                this.modalSystem.show("Định dạng file không hợp lệ");
                return false;
            }

            // Check file size
            if (file.size > CONFIG.MAX_FILE_SIZE) {
                this.modalSystem.show("Kích thước file quá lớn");
                return false;
            }

            // Check dimensions
            return new Promise((resolve) => {
                const img = new Image();
                img.src = URL.createObjectURL(file);

                img.onload = () => {
                    URL.revokeObjectURL(img.src);
                    if (
                        img.width !== CONFIG.IMAGE_WIDTH ||
                        img.height !== CONFIG.IMAGE_HEIGHT
                    ) {
                        this.modalSystem.show(
                            `Kích thước hình ảnh phải là ${CONFIG.IMAGE_WIDTH}x${CONFIG.IMAGE_HEIGHT} pixels`
                        );
                        resolve(false);
                    } else {
                        resolve(true);
                    }
                };

                img.onerror = () => {
                    URL.revokeObjectURL(img.src);
                    this.modalSystem.show("Không thể đọc file hình ảnh");
                    resolve(false);
                };
            });
        } catch (error) {
            console.error("Lỗi khi validate ảnh:", error);
            this.modalSystem.show("Có lỗi xảy ra khi kiểm tra ảnh");
            return false;
        }
    }

    previewFile(file) {
        const preview = document.getElementById("previewImage");
        if (preview && file) {
            const reader = new FileReader();
            reader.onloadend = () => {
                preview.src = reader.result;
            };
            reader.readAsDataURL(file);
        }
    }

    setDefaultImage() {
        const preview = document.getElementById("previewImage");
        if (preview) {
            preview.src = CONFIG.DEFAULT_IMAGE;
        }
    }
}

// Dropdown System
class DropdownSystem {
    constructor() {
        this.setupDropdowns();
    }

    setupDropdowns() {
        document.addEventListener("DOMContentLoaded", () => {
            document
                .querySelectorAll('[data-toggle="dropdown"]')
                .forEach((toggle) => {
                    toggle.addEventListener("click", (e) => {
                        const dropdownList = e.currentTarget.nextElementSibling;
                        const chevron =
                            e.currentTarget.querySelector(".fa-chevron-up");

                        if (dropdownList)
                            dropdownList.classList.toggle("hidden");
                        if (chevron) chevron.classList.toggle("rotate-180");
                    });
                });
        });
    }
}

class BulkDeleteSystem {
    confirmDelete() {
        const selectedPosts = document.querySelectorAll(
            'input[name="post_ids[]"]:checked'
        );
        if (selectedPosts.length > 0) {
            if (confirm("Bạn có chắc chắn muốn xóa các bài viết đã chọn?")) {
                document.getElementById("bulkDeleteForm").submit();
            }
        } else {
            new ToastSystem().show(
                "Vui lòng chọn ít nhất một bài viết để xóa.",
                "warning"
            );
        }
    }
}

// Instantiate the BulkDeleteSystem
const bulkDeleteSystem = new BulkDeleteSystem();

// Initialize systems
document.addEventListener("DOMContentLoaded", () => {
    // Initialize all systems
    const imageHandler = new ImageHandler();
    const dropdownSystem = new DropdownSystem();
    const bulkDeleteSystem = new BulkDeleteSystem();

    // Check for flash messages
    const toastSystem = new ToastSystem();
    const flashTypes = ["success", "error", "warning", "info"];

    flashTypes.forEach((type) => {
        const message = document
            .querySelector(`meta[name="flash-${type}"]`)
            ?.getAttribute("content");
        if (message) {
            toastSystem.show(message, type);
        }
    });

    // Make systems globally accessible if needed
    window.imageHandler = imageHandler;
    window.modalSystem = new ModalSystem();
    window.bulkDeleteSystem = bulkDeleteSystem;
});

// select all delete
document.getElementById("selectAll").addEventListener("click", function () {
    let checkboxes = document.querySelectorAll(".selectItem");
    checkboxes.forEach((checkbox) => {
        checkbox.checked = this.checked;
    });
});

// tính số lượng bài viết được chọn để xóa
const selectAllCheckbox = document.getElementById("selectAll"); // Lấy checkbox "Chọn tất cả"
const itemCheckboxes = document.querySelectorAll(".selectItem"); // Lấy tất cả checkbox trong bảng
const selectedCountSpan = document.getElementById("selectedCount"); // Lấy phần tử hiển thị số lượng đã chọn

// Hàm cập nhật số lượng bài viết được chọn
function updateSelectedCount() {
    const selectedCount = document.querySelectorAll(
        ".selectItem:checked"
    ).length; // Đếm số checkbox được chọn
    selectedCountSpan.textContent = selectedCount; // Cập nhật số lượng vào phần tử hiển thị
}

// Lắng nghe sự kiện thay đổi cho từng checkbox
itemCheckboxes.forEach((checkbox) => {
    checkbox.addEventListener("change", updateSelectedCount); // Gọi hàm cập nhật khi checkbox thay đổi
});

// Lắng nghe sự kiện cho checkbox "Chọn tất cả" để cập nhật tất cả checkbox và số lượng
selectAllCheckbox.addEventListener("click", function () {
    itemCheckboxes.forEach((checkbox) => {
        checkbox.checked = selectAllCheckbox.checked; // Đặt trạng thái checkbox theo trạng thái của "Chọn tất cả"
    });
    updateSelectedCount(); // Cập nhật số lượng đã chọn
});

// hàm slug thanh địa chỉ
function generateSlug() {
    const title = document.getElementById("title").value;
    const slug = title
        .normalize("NFKD")
        .replace(/[\u0300-\u036f]/g, "")
        .replace(/[đĐ]/g, "d") //Xóa dấu
        .trim()
        .toLowerCase() //Cắt khoảng trắng đầu, cuối và chuyển chữ thường
        .replace(/[^a-z0-9\s-]/g, "") //Xóa ký tự đặc biệt
        .replace(/[\s-]+/g, "-"); //Thay khoảng trắng bằng dấu -, ko cho 2 -- liên tục
    document.getElementById("slug").value = slug;
}

const titleInput = document.getElementById("title");
const slugInput = document.getElementById("slug");
const autoUpdateSlug = document.getElementById("autoUpdateSlug");
const slugDuplicateError = document.getElementById("slugDuplicateError");

let isSlugUpdated = false;

titleInput.addEventListener("input", function () {
    if (autoUpdateSlug.checked && !isSlugUpdated) {
        updateSlug();
        isSlugUpdated = true; // Chỉ cho phép cập nhật slug một lần khi checkbox được chọn
    }
});

autoUpdateSlug.addEventListener("change", function () {
    if (this.checked) {
        updateSlug(); // Cập nhật slug ngay khi checkbox được chọn
        isSlugUpdated = true; // Đánh dấu đã cập nhật slug
    } else {
        isSlugUpdated = false; // Cho phép cập nhật lại nếu checkbox được chọn lại
    }
});

function updateSlug() {
    const slug = titleInput.value
        .trim()
        .normalize("NFKD")
        .replace(/[\u0300-\u036f]/g, "")
        .replace(/[đĐ]/g, "d") //Xóa dấu
        .toLowerCase() //Cắt khoảng trắng đầu, cuối và chuyển chữ thường
        .replace(/[^a-z0-9\s-]/g, "") //Xóa ký tự đặc biệt
        .replace(/[\s-]+/g, "-"); //Thay khoảng trắng bằng dấu -, ko cho 2 -- liên tục
    slugInput.value = slug;
    checkSlugDuplicate(slug);
}

function checkSlugDuplicate(slug) {
    fetch(`/check-slug?slug=${slug}`)
        .then((response) => response.json())
        .then((data) => {
            if (data.exists) {
                slugDuplicateError.classList.remove("hidden");
            } else {
                slugDuplicateError.classList.add("hidden");
            }
        })
        .catch((error) => console.error("Error:", error));
}
