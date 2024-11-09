// $(document).ready(function () {
//     // Setup CSRF token
//     $.ajaxSetup({
//         headers: {
//             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
//             Accept: "application/json", // Thêm header này để Laravel nhận biết request ajax
//         },
//     });

//     let searchTimeout;
//     const searchDelay = 300;

//     // Handle form submission
//     $("#search-form").on("submit", function (e) {
//         e.preventDefault();
//         const searchTerm = $("#search-input").val();
//         performSearch(searchTerm);
//     });

//     // Handle real-time search
//     $("#search-input").on("input", function () {
//         const searchTerm = $(this).val();
//         clearTimeout(searchTimeout);

//         searchTimeout = setTimeout(() => {
//             performSearch(searchTerm);
//         }, searchDelay);
//     });

//     function performSearch(searchTerm, page = 1) {
//         console.log("Performing search for:", searchTerm); // Debug log

//         $("#search-loading").removeClass("hidden");

//         $.ajax({
//             url: window.location.href,
//             method: "GET",
//             data: {
//                 search: searchTerm,
//                 page: page
//             },
//             success: function (response) {
//                 console.log("Search response:", response); // Debug log

//                 if (response.posts && response.posts.length > 0) {
//                     updatePostsTable(response.posts);
//                     $("#no-results").addClass("hidden");
//                     updatePagination(response.pagination);
//                 } else {
//                     $("#posts-tbody").empty();
//                     $("#no-results")
//                         .removeClass("hidden")
//                         .text("Không tìm thấy kết quả nào");
//                 }
//             },
//             error: function (xhr, status, error) {
//                 console.error("Search error:", error);
//                 console.error("Response:", xhr.responseText); // Thêm log này

//                 Swal.fire({
//                     icon: "error",
//                     title: "Lỗi tìm kiếm",
//                     text:
//                         xhr.responseJSON?.error ||
//                         "Đã có lỗi xảy ra khi tìm kiếm. Vui lòng thử lại sau.",
//                 });
//             },
//             complete: function () {
//                 $("#search-loading").addClass("hidden");
//             },
//         });
//     }
//     // Hàm cập nhật phân trang
//     function updatePagination(pagination) {
//         // Tạo HTML cho phân trang
//         let paginationHtml = "";

//         if (pagination.last_page > 1) {
//             paginationHtml += `<div class="flex justify-center space-x-1">`;

//             // Previous Page
//             if (pagination.current_page > 1) {
//                 paginationHtml += `
//                 <button class="px-4 py-2 text-gray-500 bg-white rounded-lg hover:bg-gray-100" 
//                         onclick="changePage(${pagination.current_page - 1})">
//                     Previous
//                 </button>`;
//             }

//             // Page Numbers
//             for (let i = 1; i <= pagination.last_page; i++) {
//                 if (i === pagination.current_page) {
//                     paginationHtml += `
//                     <button class="px-4 py-2 text-white bg-blue-600 rounded-lg">
//                         ${i}
//                     </button>`;
//                 } else {
//                     paginationHtml += `
//                     <button class="px-4 py-2 text-gray-500 bg-white rounded-lg hover:bg-gray-100" 
//                             onclick="changePage(${i})">
//                         ${i}
//                     </button>`;
//                 }
//             }

//             // Next Page
//             if (pagination.current_page < pagination.last_page) {
//                 paginationHtml += `
//                 <button class="px-4 py-2 text-gray-500 bg-white rounded-lg hover:bg-gray-100" 
//                         onclick="changePage(${pagination.current_page + 1})">
//                     Next
//                 </button>`;
//             }

//             paginationHtml += `</div>`;
//         }

//         $("#pagination").html(paginationHtml);
//     }

//     // Hàm đổi trang
// function changePage(page) {
//     const searchTerm = $("#search-input").val();
//     performSearch(searchTerm, page);
// }


//     function updatePostsTable(posts) {
//         const $tbody = $("#posts-tbody");
//         $tbody.empty();

//         posts.forEach((post, index) => {
//             const row = `
//                 <tr class="hover:bg-gray-50">
//                     <td class="py-2 px-4 border-b text-center">
//                         <input type="checkbox" name="post_ids[]" value="${
//                             post.id
//                         }" class="selectItem" />
//                     </td>
//                     <td class="py-2 px-4 border-b text-center">${index + 1}</td>
//                     <td class="py-2 px-4 border-b text-center">
//                         <img 
//                             class="h-20 w-20 object-cover rounded mx-auto"
//                             src="${
//                                 post.image
//                                     ? `/storage/${post.image}`
//                                     : "/images/no-image-available.jpg"
//                             }"
//                             alt="${escapeHtml(post.title)}"
//                         />
//                     </td>
//                     <td class="py-2 px-4 border-b">
//                         <div class="font-medium">${escapeHtml(post.title)}</div>
//                         <div class="text-sm text-gray-500">
//                             Ngày tạo: ${formatDate(post.created_at)}
//                         </div>
//                     </td>
//                     <td class="py-2 px-4 border-b text-center">
//                         <input type="checkbox" 
//                                ${post.is_featured ? "checked" : ""} 
//                                onchange="updateFeatured(${
//                                    post.id
//                                }, this.checked)"
//                                title="Nổi bật bài viết" />
//                     </td>
//                     <td class="py-2 px-4 border-b text-center">
//                         <input type="checkbox" 
//                                ${post.is_published ? "checked" : ""} 
//                                onchange="updatePublished(${
//                                    post.id
//                                }, this.checked)"
//                                title="Hiển thị bài viết" />
//                     </td>
//                     <td class="py-2 px-4 border-b text-center">
//                         <div class="flex items-center justify-center space-x-2">
//                             <button onclick="copyPost(${post.id})" 
//                                     class="text-green-600 hover:text-green-800"
//                                     title="Sao chép">
//                                 <i class="fas fa-copy"></i>
//                             </button>
//                             <a href="/admin/posts/edit/${post.id}" 
//                                class="text-blue-600 hover:text-blue-800"
//                                title="Sửa">
//                                 <i class="fas fa-edit"></i>
//                             </a>
//                             <button onclick="deletePost(${post.id})"
//                                     class="text-red-600 hover:text-red-800"
//                                     title="Xóa">
//                                 <i class="fas fa-trash"></i>
//                             </button>
//                         </div>
//                     </td>
//                 </tr>
//             `;
//             $tbody.append(row);
//         });
//     }

//     // Helper Functions
//     function escapeHtml(unsafe) {
//         return unsafe
//             .replace(/&/g, "&amp;")
//             .replace(/</g, "&lt;")
//             .replace(/>/g, "&gt;")
//             .replace(/"/g, "&quot;")
//             .replace(/'/g, "&#039;");
//     }

//     function formatDate(dateString) {
//         return new Date(dateString).toLocaleDateString("vi-VN", {
//             year: "numeric",
//             month: "long",
//             day: "numeric",
//             hour: "2-digit",
//             minute: "2-digit",
//         });
//     }
// });

// // Additional functions for actions
// function updateFeatured(postId, status) {
//     $.ajax({
//         url: `/admin/posts/${postId}/featured`,
//         method: "POST",
//         data: {
//             is_featured: status,
//         },
//         success: function (response) {
//             Toast.fire({
//                 icon: "success",
//                 title: "Cập nhật thành công",
//             });
//         },
//         error: function () {
//             Swal.fire({
//                 icon: "error",
//                 title: "Lỗi",
//                 text: "Không thể cập nhật trạng thái nổi bật",
//             });
//         },
//     });
// }

// function updatePublished(postId, status) {
//     $.ajax({
//         url: `/admin/posts/${postId}/publish`,
//         method: "POST",
//         data: {
//             is_published: status,
//         },
//         success: function (response) {
//             Toast.fire({
//                 icon: "success",
//                 title: "Cập nhật thành công",
//             });
//         },
//         error: function () {
//             Swal.fire({
//                 icon: "error",
//                 title: "Lỗi",
//                 text: "Không thể cập nhật trạng thái xuất bản",
//             });
//         },
//     });
// }

// // SweetAlert2 Toast configuration
// const Toast = Swal.mixin({
//     toast: true,
//     position: "top-end",
//     showConfirmButton: false,
//     timer: 3000,
//     timerProgressBar: true,
// });
