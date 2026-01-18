$(function() {
    const urlParams = new URLSearchParams(window.location.search);
    const module = urlParams.get('c') || 'student';

    function showToast(msg, type = 'success') {
        const toast = document.getElementById('toastNotification');
        toast.querySelector('.toast-body').textContent = msg;
        toast.classList.remove('bg-success', 'bg-danger');
        toast.classList.add(type === 'success' ? 'bg-success' : 'bg-danger');
        new bootstrap.Toast(toast).show();
    }

    function loading(show = true) {
        $('#loadingOverlay').toggleClass('d-none', !show);
    }

    function loadList() {
        loading(true);
        $.get(`index.php?c=${module}&a=api_list`, function(res) {
            let rows = '';
            if (res.success && res.data.length) {
                res.data.forEach((item, i) => {
                    const code = item.code || item.isbn || item.member_code || '-';
                    const name = item.full_name || item.title || '-';
                    const email = item.email || item.author || '-';
                    const extra = item.dob || item.category || item.phone || item.quantity || '-';
                    rows += `<tr>
                        <td>${i + 1}</td>
                        <td>${code}</td>
                        <td>${name}</td>
                        <td>${email}</td>
                        <td>${extra}</td>
                        <td>
                            <button class="btn btn-sm btn-warning" onclick="edit(${item.id})">Sửa</button>
                            <button class="btn btn-sm btn-danger" onclick="del(${item.id})">Xóa</button>
                        </td>
                    </tr>`;
                });
            } else {
                rows = '<tr><td colspan="6" class="text-center py-4">Chưa có dữ liệu</td></tr>';
            }
            $('#dataList').html(rows);
            loading(false);
        });
    }

    $('#mainForm').submit(function(e) {
        e.preventDefault();
        loading(true);
        const action = $('[name="id"]').val() ? 'api_update' : 'api_create';
        $.post(`index.php?c=${module}&a=${action}`, $(this).serialize(), function(res) {
            if (res.success) {
                showToast(res.message);
                this.reset();
                $('[name="id"]').val('');
                loadList();
            } else {
                showToast(Object.values(res.errors || {}).join(', '), 'danger');
            }
            loading(false);
        });
    });

    window.edit = function(id) {
        $.get(`index.php?c=${module}&a=api_get&id=${id}`, function(res) {
            if (res.success) {
                $('[name="id"]').val(res.data.id);
                $('[name="code"], [name="isbn"], [name="member_code"]').val(res.data.code || res.data.isbn || res.data.member_code || '');
                $('[name="full_name"], [name="title"]').val(res.data.full_name || res.data.title || '');
                $('[name="email"], [name="author"]').val(res.data.email || res.data.author || '');
                $('[name="dob"], [name="category"], [name="phone"], [name="quantity"]').val(res.data.dob || res.data.category || res.data.phone || res.data.quantity || '');
            }
        });
    };

    window.del = function(id) {
        if (confirm('Xóa bản ghi này?')) {
            loading(true);
            $.post(`index.php?c=${module}&a=api_delete`, {id}, function(res) {
                showToast(res.message, res.success ? 'success' : 'danger');
                loadList();
            });
        }
    };

    loadList();
});