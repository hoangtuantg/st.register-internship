import { renderAsync } from "docx-preview";

window.loadDocxFile = function (fileUrl, groupId) {
    fetch(fileUrl)
        .then(response => response.arrayBuffer())
        .then(data => {
            let container = document.getElementById("word-preview-" + groupId);
            if (!container) return;

            // Xóa nội dung cũ trước khi hiển thị mới
            container.innerHTML = "";

            renderAsync(data, container, null, {
                className: "docx-container",
                inWrapper: true
            }).catch(err => {
                console.error("Lỗi khi hiển thị file DOCX:", err);
                container.innerHTML = "<p class='text-danger'>Không thể xem trước file này.</p>";
            });
        })
        .catch(err => {
            console.error("Lỗi khi tải file Word:", err);
            document.getElementById("word-preview-" + groupId).innerHTML = "<p class='text-danger'>Không thể tải file.</p>";
        });
};
