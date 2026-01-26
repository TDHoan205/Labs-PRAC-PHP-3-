$(document).ready(function () {
    
    // --- Hàm 1: Tô sáng từ khóa (Highlight) ---
    function highlightText(text, keyword) {
        if (!keyword || !text) return text;
        // escape regex special chars in keyword
        const esc = keyword.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        let regex = new RegExp(`(${esc})`, "gi"); // "gi" không phân biệt hoa thường
        return text.replace(regex, "<mark>$1</mark>");
    }

    // --- Hàm 2: Vẽ bảng dữ liệu ---
    function renderTable(data, keyword = '') {
        let html = '';
        if (data.length === 0) {
            $('#tbData').html('<tr><td colspan="6" class="text-center text-danger">Không tìm thấy sản phẩm!</td></tr>');
            return;
        }

        data.forEach(item => {
            let price = new Intl.NumberFormat('vi-VN').format(item.price);
            
            // Gọi hàm Highlight cho Mã và Tên
            let displayCode = highlightText(item.code, keyword);
            let displayName = highlightText(item.name, keyword);

            html += `
                <tr id="row-${item.id}">
                    <td>${item.id}</td>
                    <td>${displayCode}</td>
                    <td>${displayName}</td>
                    <td>${price} ₫</td>
                    <td>${item.created_at}</td>
                    <td>
                        <button class="btn btn-danger btn-sm btnDelete" data-id="${item.id}">Xóa</button>
                    </td>
                </tr>
            `;
        });
        $('#tbData').html(html);
    }

    // --- Hàm 3: Gọi API Tìm kiếm ---
    function fetchProducts(query = '') {
        $.ajax({
            url: 'api/products/search.php',
            method: 'GET',
            data: { q: query },
            dataType: 'json',
            beforeSend: function () { $('#loading').show(); },
            complete: function () { $('#loading').hide(); },
            success: function (res) {
                if (!res || typeof res.success === 'undefined') {
                    alert('Invalid response from server');
                    return;
                }
                if (res.success) {
                    renderTable(res.data || [], query);
                } else {
                    alert(res.message || 'Lỗi server');
                }
            },
            error: function (xhr) {
                alert('Lỗi Ajax: ' + xhr.status + ' ' + xhr.statusText);
                $('#tbData').html('<tr><td colspan="6" class="text-center text-danger">Lỗi tải dữ liệu</td></tr>');
            }
        });
    }

    // Gọi lần đầu khi load trang
    fetchProducts();

    // Sự kiện Gõ phím (Live Search + Debounce)
    let timer;
    $('#txtSearch').on('keyup', function () {
        clearTimeout(timer);
        let q = $(this).val().trim();
        timer = setTimeout(() => { fetchProducts(q); }, 300);
    });

    // Sự kiện Click Xóa (Ajax Delete + Confirm)
    $(document).on('click', '.btnDelete', function () {
        const $btn = $(this);
        const id = $btn.data('id');
        if (!confirm('Bạn có chắc chắn muốn xóa?')) return;
        $.ajax({
            url: 'api/products/delete.php',
            method: 'POST',
            data: { id: id },
            dataType: 'json',
            beforeSend: function () { $btn.prop('disabled', true); },
            complete: function () { $btn.prop('disabled', false); },
            success: function (res) {
                if (!res || typeof res.success === 'undefined') {
                    alert('Invalid response from server');
                    return;
                }
                if (res.success) {
                    $(`#row-${id}`).fadeOut(300, function () { $(this).remove(); });
                } else {
                    alert(res.message || 'Lỗi xóa!');
                }
            },
            error: function (xhr) {
                alert('Lỗi Ajax: ' + xhr.status + ' ' + xhr.statusText);
            }
        });
    });
});