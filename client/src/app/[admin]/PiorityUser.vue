<template>
    <Sidebar></Sidebar>

    <div class="container">
        <div class="head">
            <div class="search">
                <input type="text" placeholder="Tìm kiếm">
            </div>
            <div class="actions">
                <button>Tải xuống PDF</button>
                <button>Mới nhất</button>
            </div>
        </div>

        <div class="view-by">
            <div class="active">Show All</div>
            <div>Thân Thiết</div>
            <div>Vip</div>
            <div>Khách hàng</div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Họ Tên</th>
                    <th>Ngày tạo</th>
                    <th>SDT/Email</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#AD-001245</td>
                    <td>Trần Văn A</td>
                    <td>11-10-2021</td>
                    <td>06363737383</td>
                    <td>Đang hoạt động</td>
                </tr>
                <tr>
                    <td>#NV-001246</td>
                    <td>Nguyễn Văn B</td>
                    <td>11-10-2021</td>
                    <td>0123456789</td>
                    <td>Đang hoạt động</td>
                </tr>
            </tbody>
        </table>

        <div class="pagination">
            <button>Previous</button>
            <button>1</button>
            <button>2</button>
            <button class="active">3</button>
            <button>Next</button>
        </div>
    </div>

</template>
<script>
// Toggle active state for filters
document.querySelectorAll('.filter').forEach(filter => {
    filter.addEventListener('click', () => {
        document.querySelectorAll('.filter').forEach(btn => btn.classList.remove('active'));
        filter.classList.add('active');
    });
});
</script>
<style>
.container {
    width: 100%;
    height: 100%;
    /* max-width: 1200px; */
    /* height: 800px; */
    /* margin: 20px; */
    background-color: #f4f6f9;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    font-family: 'Arial', sans-serif;

}

/* .main {
    width: 100vh;
    height: 100%;
    flex: 1;
    padding: 20px;
} */

.head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
}

.search {
    flex: 1;
    margin-right: 20px;
}

.search input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.actions {
    display: flex;
    align-items: center;
}

.actions button {
    margin-left: 10px;
    padding: 10px 20px;
    background-color: #3498db;
    color: #ffffff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.actions button:hover {
    background-color: #2980b9;
}

.table {
    width: 100%;
    border-collapse: collapse;
    background-color: #ffffff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    overflow: hidden;
}

.table th,
.table td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #f1f1f1;
}

.table th {
    background-color: #f9fafb;
    font-weight: bold;
}

.table tr:hover td {
    background-color: #f1f7ff;
}

.pagination {
    margin-top: 20px;
    display: flex;
    justify-content: flex-end;
    align-items: center;
}

.pagination button {
    margin-left: 5px;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    background-color: #f1f1f1;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.pagination button:hover {
    background-color: #e0e0e0;
}

.pagination button.active {
    background-color: #4caf50;
    color: #ffffff;
}

.view-by {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
}

.view-by div {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    cursor: pointer;
}

.view-by div.active {
    border-color: #4caf50;
    background-color: #f1f7ff;
}

@media (max-width: 768px) {
    .container {
        padding: 15px;
    }

    .head {
        flex-direction: column;
        align-items: flex-start;
    }

    .search {
        width: 100%;
        margin-bottom: 10px;
    }

    .actions {
        width: 100%;
        justify-content: flex-start;
    }

    .actions button {
        flex: 1;
        text-align: center;
    }

    .table th,
    .table td {
        padding: 10px;
        font-size: 14px;
    }

    .view-by {
        flex-wrap: wrap;
    }

    .pagination {
        justify-content: center;
    }

    .pagination button {
        padding: 8px 12px;
        font-size: 14px;
    }
}
</style>