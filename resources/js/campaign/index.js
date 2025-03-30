window.addEventListener('openDeleteModal', () => {
    new swal({
        title: "Bạn có chắc chắn?",
        text: "Dữ liệu sau khi xóa không thể phục hồi!",
        showCancelButton: true,
        confirmButtonColor: "#FF7043",
        confirmButtonText: "Đồng ý!",
        cancelButtonText: "Đóng!"
    }).then((value) => {
        if (value.isConfirmed) {
            Livewire.dispatch('deleteCampaign')
        }
    })
})
