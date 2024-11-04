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
                this.modalSystem.show(
                    "Dung lượng hình ảnh lớn. Dung lượng cho phép <= 5MB ~ 5096KB"
                );
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
                        img.height < CONFIG.IMAGE_HEIGHT
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
    document.getElementById('slugurlpreviewvi').querySelector('strong').textContent = slug;
}

// function slugConvert(slug, focus = false) {
//     slug = slug.toLowerCase();
//     slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, "a");
//     slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, "e");
//     slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, "i");
//     slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, "o");
//     slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, "u");
//     slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, "y");
//     slug = slug.replace(/đ/gi, "d");
//     slug = slug.replace(
//         /\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi,
//         ""
//     );
//     slug = slug.replace(/ /gi, "-");
//     slug = slug.replace(/\-\-\-\-\-/gi, "-");
//     slug = slug.replace(/\-\-\-\-/gi, "-");
//     slug = slug.replace(/\-\-\-/gi, "-");
//     slug = slug.replace(/\-\-/gi, "-");

//     if (!focus) {
//         slug = "@" + slug + "@";
//         slug = slug.replace(/\@\-|\-\@|\@/gi, "");
//     }

//     return slug;
// }
// function slugPreview(title, lang, focus = false) {
//     var slug = slugConvert(title, focus);

//     $("#slug" + lang).val(slug);
//     $("#slugurlpreview" + lang + " strong").html(slug);
//     $("#seourlpreview" + lang + " strong").html(slug);
// }
// function slugPreviewTitleSeo(title, lang) {
//     if ($("#title" + lang).length) {
//         var titleSeo = $("#title" + lang).val();
//         if (!titleSeo) {
//             if (title) $("#title-seo-preview" + lang).html(title);
//             else $("#title-seo-preview" + lang).html("Title");
//         }
//     }
// }
// function slugPress() {
//     var sluglang = "vi,en";
//     var inputArticle = $(".card-article input.for-seo");
//     var id = $(".slug-id").val();
//     var seourlstatic = true;
//     //var seourlstatic = $(".slug-seo-preview").data("seourlstatic");

//     inputArticle.each(function (index) {
//         var ten = $(this).attr("id");
//         var lang = ten.substr(ten.length - 2);
//         if (sluglang.indexOf(lang) >= 0) {
//             if ($("#" + ten).length) {
//                 $("body").on("keyup", "#" + ten, function () {
//                     var title = $("#" + ten).val();

//                     if (
//                         (!id || $("#slugchange").prop("checked")) &&
//                         seourlstatic
//                     ) {
//                         /* Slug preivew */
//                         slugPreview(title, lang);
//                     }

//                     /* Slug preivew title seo */
//                     slugPreviewTitleSeo(title, lang);

//                     /* slug Alert */
//                     slugAlert(2, lang);
//                 });
//             }

//             if ($("#slug" + lang).length) {
//                 $("body").on("keyup", "#slug" + lang, function () {
//                     var title = $("#slug" + lang).val();

//                     /* Slug preivew */
//                     slugPreview(title, lang, true);

//                     /* slug Alert */
//                     slugAlert(2, lang);
//                 });
//             }
//         }
//     });
// }
// function slugChange(obj) {
//     if (obj.is(":checked")) {
//         /* Load slug theo tiêu đề mới */
//         slugStatus(1);
//         $(".slug-input").attr("readonly", true);
//     } else {
//         /* Load slug theo tiêu đề cũ */
//         slugStatus(0);
//         $(".slug-input").attr("readonly", false);
//     }
// }
// function slugStatus(status) {
//     var sluglang = "vi,en";
//     var inputArticle = $(".card-article input.for-seo");

//     inputArticle.each(function (index) {
//         var ten = $(this).attr("id");
//         var lang = ten.substr(ten.length - 2);
//         if (sluglang.indexOf(lang) >= 0) {
//             var title = "";
//             if (status == 1) {
//                 if ($("#" + ten).length) {
//                     title = $("#" + ten).val();

//                     /* Slug preivew */
//                     slugPreview(title, lang);

//                     /* Slug preivew title seo */
//                     slugPreviewTitleSeo(title, lang);
//                 }
//             } else if (status == 0) {
//                 if ($("#slug-default" + lang).length) {
//                     title = $("#slug-default" + lang).val();

//                     /* Slug preivew */
//                     slugPreview(title, lang);

//                     /* Slug preivew title seo */
//                     slugPreviewTitleSeo(title, lang);
//                 }
//             }
//         }
//     });
// }
// function slugAlert(result, lang) {
//     if (result == 1) {
//         $("#alert-slug-danger" + lang).addClass("d-none");
//         $("#alert-slug-success" + lang).removeClass("d-none");
//     } else if (result == 0) {
//         $("#alert-slug-danger" + lang).removeClass("d-none");
//         $("#alert-slug-success" + lang).addClass("d-none");
//     } else if (result == 2) {
//         $("#alert-slug-danger" + lang).addClass("d-none");
//         $("#alert-slug-success" + lang).addClass("d-none");
//     }
// }
// function slugCheck() {
//     var sluglang = "vi,en";
//     var slugInput = $(".slug-input");
//     var id = $(".slug-id").val(); // Giả sử đây là post_id
//     var copy = $(".slug-copy").val();

//     slugInput.each(function (index) {
//         var slugId = $(this).attr("id");
//         var slug = $(this).val();
//         var lang = slugId.substr(slugId.length - 2);
//         if (sluglang.indexOf(lang) >= 0) {
//             if (slug) {
//                 $.ajax({
//                     url: "/slug/check", // Đường dẫn đến phương thức checkSlug trong SlugController
//                     type: "POST",
//                     dataType: "json", // Thay đổi thành json để xử lý dữ liệu trả về
//                     async: false,
//                     data: {
//                         slug: slug,
//                         post_id: id, // Gửi post_id (hoặc id của đối tượng mà bạn muốn kiểm tra)
//                         _token: $('meta[name="csrf-token"]').attr("content"), // Nếu bạn có sử dụng CSRF
//                     },
//                     success: function (result) {
//                         slugAlert(result.message, lang);
//                     },
//                     error: function (xhr) {
//                         console.error(xhr.responseText); // Log lỗi nếu có
//                     },
//                 });
//             }
//         }
//     });
// }

// Track form changes
let formChanged = false;
const form = document.getElementById("postForm");
const originalFormData = new FormData(form);

// Function to check if form has changed
function hasFormChanged() {
    const currentFormData = new FormData(form);
    for (const [key, value] of currentFormData.entries()) {
        if (originalFormData.get(key) !== value) {
            return true;
        }
    }
    return false;
}

