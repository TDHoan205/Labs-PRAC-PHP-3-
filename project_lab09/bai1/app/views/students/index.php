<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Quản lý Sinh viên</h4>
            </div>
            <div class="card-body">
                <form id="mainForm" class="row g-3 mb-4">
                    <input type="hidden" name="id">
                    <div class="col-md-3">
                        <label class="form-label">Mã SV</label>
                        <input type="text" name="code" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Họ tên</label>
                        <input type="text" name="full_name" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Ngày sinh</label>
                        <input type="date" name="dob" class="form-control">
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-success">Thêm sinh viên</button>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>STT</th>
                                <th>Mã SV</th>
                                <th>Họ tên</th>
                                <th>Email</th>
                                <th>Ngày sinh</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody id="dataList"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>