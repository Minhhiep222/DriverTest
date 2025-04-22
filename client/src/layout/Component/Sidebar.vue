<!-- <template>
    <nav class="sidebar">
        <ul class="menu">
            <li><a href="#" class="active">Trang chủ</a></li>
            <li><a href="#">Chương trình lái thử</a></li>
            <li class="has-submenu">
                <a href="#" class="toggle-menu"
                    >Khách Hàng<span><ion-icon name="chevron-down-outline"></ion-icon></span
                ></a>
                <ul class="submenu">
                    <li><a href="#">Mức độ khách hàng</a></li>
                </ul>
            </li>
            <li class="has-submenu">
                <a href="#" class="toggle-menu"
                    >Chăm Sóc Khách Hàng<span><ion-icon name="chevron-down-outline"></ion-icon></span
                ></a>
                <ul class="submenu">
                    <li><a href="#">Trước khi lái</a></li>
                    <li><a href="#">Sau khi lái</a></li>
                </ul>
            </li>
            <li><a href="/drive-management">Báo cáo</a></li>
            <li><a href="#">Hóa đơn</a></li>
            <li><a href="#">Thống kê</a></li>
        </ul>
        <button class="logout">Đăng xuất</button>
    </nav>
</template> -->

<script>
    import {useRouter} from 'vue-router';
    export default {
        mounted() {
            // Chạy logic JavaScript ở đây
            const toggleMenus = document.querySelectorAll('.menu .has-submenu > a');

            toggleMenus.forEach((menu) => {
                menu.addEventListener('click', function (event) {
                    event.preventDefault(); // Ngăn chặn hành động mặc định

                    const parent = menu.closest('.has-submenu');
                    const submenu = parent.querySelector('.submenu');

                    // Đóng tất cả các submenu khác
                    document.querySelectorAll('.menu .has-submenu').forEach((item) => {
                        if (item !== parent) {
                            item.classList.remove('open');
                        }
                    });

                    // Toggle trạng thái open
                    parent.classList.toggle('open');
                });
            });
        },
    };
    const goToAddCustomer = () => {
        router.push('/add-customer');
    };
</script>

<style>
    /* Sidebar */
    .sidebar {
        width: 250px;
        background-color: #f9f9f9;
        color: #333;
        display: flex;
        flex-direction: column;
        align-items: stretch;
        padding: 20px;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        font-family: 'Arial', sans-serif;
    }

    /* Menu Styles */
    .menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .menu li {
        position: relative;
    }

    .menu a {
        text-decoration: none;
        color: #333;
        padding: 12px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-radius: 8px;
        font-size: 16px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .menu a.active {
        background-color: #4caf50;
        font-weight: bold;
        color: #fff;
    }

    .menu a:hover {
        background-color: #e8f5e9;
        color: #4caf50;
        font-weight: bold;
    }

    /* Submenu */
    .menu .has-submenu > .submenu {
        display: none;
        list-style: none;
        padding-left: 20px;
        margin-top: 5px;
    }

    .menu .has-submenu.open > .submenu {
        display: block;
        padding-left: 15px;
    }

    .menu .submenu li {
        padding: 5px 0;
    }

    .menu .submenu a {
        font-size: 14px;
        padding: 8px 15px;
        color: #555;
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    .menu .submenu a:hover {
        background-color: #f1f1f1;
        color: #4caf50;
    }

    /* Icon Styles */
    .menu a ion-icon {
        font-size: 16px;
        margin-left: 10px;
    }

    /* Logout Button */
    .logout {
        margin-top: auto;
        padding: 12px 20px;
        background-color: #e74c3c;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        text-align: center;
    }

    .logout:hover {
        background-color: #c0392b;
    }

    /* Responsive Design */
    @media screen and (max-width: 768px) {
        .sidebar {
            width: 200px;
        }

        .menu a {
            font-size: 14px;
            padding: 10px 16px;
        }

        .logo img {
            width: 80px;
            height: 80px;
        }

        .logout {
            font-size: 14px;
            padding: 10px 16px;
        }
    }
</style>
