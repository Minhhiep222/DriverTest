<template>
    <div class="container">
        <div class="dashboard-container">
            <!-- Top Bar -->
            <div class="flex justify-between items-center p-4 bg-white shadow-md rounded-lg">
                <!-- Tìm kiếm -->
                <div class="flex items-center border rounded-lg px-2 py-1 w-full md:w-1/3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" placeholder="Tìm kiếm" class="ml-2 w-full outline-none" />
                </div>
                <!-- <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-2 cursor-pointer" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-2 cursor-pointer" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <img src="@/img/avatar.jpg" alt="User Avatar" class="w-8 h-8 rounded-full cursor-pointer">
            </div> -->

            </div>


            <!-- Thông tin chung -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 p-4">
                <div class="bg-blue-100 p-4 rounded-lg shadow-md text-center">
                    <h3 class="text-lg font-semibold">Tổng Khách hàng</h3>
                    <div class="text-2xl font-bold">5000</div>
                    <div class="text-green-600">+10,25% <span class="text-gray-500">so với quý trước</span></div>
                </div>
                <div class="bg-green-100 p-4 rounded-lg shadow-md text-center">
                    <h3 class="text-lg font-semibold">Khách Hàng mới</h3>
                    <div class="text-2xl font-bold">1.080</div>
                    <div class="text-green-600">+6,25% <span class="text-gray-500">so với tháng trước</span></div>
                </div>
                <div class="bg-red-100 p-4 rounded-lg shadow-md text-center">
                    <h3 class="text-lg font-semibold">Khách hàng rời đi</h3>
                    <div class="text-2xl font-bold">80</div>
                    <div class="text-red-600">-0,25% <span class="text-gray-500">so với quý trước</span></div>
                </div>
                <div class="bg-yellow-100 p-4 rounded-lg shadow-md text-center">
                    <h3 class="text-lg font-semibold">Doanh thu</h3>
                    <div class="text-2xl font-bold">1.400.000</div>
                    <div class="text-green-600">+5,14% <span class="text-gray-500">so với tháng trước</span></div>
                </div>
            </div>


            <!-- Main Content Area -->
            <div class="main-content">
                <!-- Left Column -->
                <div class="left-column">
                    <!-- Customer Count Chart -->
                    <div class="chart-section">
                        <div class="section-header">
                            Số lượng Khách hàng
                            <div class="filter-icon"><i class="fas fa-filter"></i></div>
                        </div>
                        <div class="chart-date">Tính đến thời điểm hiện tại 30/12/2024</div>
                        <div class="donut-chart">
                            <div class="donut-chart-inner">
                                5000
                                <div class="label">Khách hàng</div>
                            </div>
                        </div>
                        <div class="chart-legend">
                            <div class="legend-item"><span class="legend-color gara"></span>Gara <span class=""> -
                                    40%</span></div>
                            <div class="legend-item"><span class="legend-color ctyoto"></span>Cty oto <span class=""> -
                                    30%</span></div>
                            <div class="legend-item"><span class="legend-color tunhan"></span>Tư Nhân <span class=""> -
                                    30%</span></div>
                        </div>
                    </div>
                    <!-- Checklist Completion -->
                    <div class="checklist-section">
                        <div class="section-header">
                            Tỷ lệ hoàn thành check list
                            <div class="filter-icon"><i class="fas fa-filter"></i></div>
                        </div>
                        <div class="checklist-date">Tính đến thời điểm hiện tại 30/12/2024.</div>
                        <div class="checklist-progress">
                            <div class="progress-circle">
                                <div
                                    class="progress-fill"
                                    :style="{transform: `rotate(${(percent / 100) * 360}deg)`}"></div>
                                <div class="progress-inner">
                                    <div class="progress-percent">
                                        Chiếm {{ percent }}% <br />
                                        {{ value }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="checklist-description">
                            Tỷ lệ này chỉ tính trên những checklist <br />
                            hoàn thành đúng thời hạn
                        </div>
                        <button class="create-store-button">Create a Store</button>
                        <div class="chart-legend">
                            <div class="legend-item"><span class="legend-color amountx"></span>Amount X</div>
                            <div class="legend-item"><span class="legend-color amounty"></span>Amount Y</div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="right-column">
                    <div class="section-header">
                        Góp ý của khách hàng
                        <div class="filter-icon"><i class="fas fa-filter"></i></div>
                    </div>
                    <div class="chart-date">Tháng 10/2024</div>
                    <div class="feedback-summary">
                        <div class="feedback-item">
                            <div class="feedback-label">Tổng góp ý</div>
                            <div class="feedback-value">20.000</div>
                        </div>
                        <div class="feedback-item">
                            <div class="feedback-label">Tư Nhân</div>
                            <div class="feedback-value">4.000</div>
                        </div>
                        <div class="feedback-item">
                            <div class="feedback-label">Gara-Showroom</div>
                            <div class="feedback-value">9.000</div>
                        </div>
                        <div class="feedback-item">
                            <div class="feedback-label">Doanh Nghiệp</div>
                            <div class="feedback-value">7.000 VND</div>
                        </div>
                    </div>
                    <table class="feedback-table">
                        <thead>
                            <tr>
                                <th>Tên Cty<i class="fas fa-sort"></i></th>
                                <th>Số Lượng Khách Hàng<i class="fas fa-sort"></i></th>
                                <th>Doanh Thu <i class="fas fa-sort"></i></th>
                                <th>Tình trạng<i class="fas fa-sort"></i></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import "../../assets/admin.css";
export default {
    data() {
        return {
            percent: 55,
            value: 1340,
        }
    },
};
</script>
