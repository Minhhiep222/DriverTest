<template>
  <a-card class="test-drive-details-user" :bordered="false">
    <a-typography-title :level="2" class="text-center mb-4">
      Danh Sách Khách Hàng Đăng Ký Lái Thử
    </a-typography-title>
    <div v-if="currentUser === 1 && registrations.length > 0">
      <a-table
        :columns="columns"
        :data-source="registrations"
        :row-key="(record) => record.id"
        @row-click="showDetails"
        :pagination="false"
        class="registration-table">
        <template #expandedRowRender="{record}">
          <a-descriptions :column="{xs: 1, sm: 2, md: 3}">
            <a-descriptions-item label="Tên khách hàng">{{
              record.customerName
            }}</a-descriptions-item>
            <a-descriptions-item label="Số điện thoại">{{
              record.phone
            }}</a-descriptions-item>
            <a-descriptions-item label="Email">{{
              record.email
            }}</a-descriptions-item>
            <a-descriptions-item label="Loại xe đăng ký">{{
              record.carModel
            }}</a-descriptions-item>
            <a-descriptions-item label="Màu xe">{{
              record.carColor
            }}</a-descriptions-item>
            <a-descriptions-item label="Tình trạng gia đình">{{
              record.familyStatus
            }}</a-descriptions-item>
            <a-descriptions-item label="Đã có bằng lái xe chưa">{{
              record.hasDriverLicense ? 'Có' : 'Không'
            }}</a-descriptions-item>
            <a-descriptions-item label="Ngày đăng ký">{{
              record.date
            }}</a-descriptions-item>
          </a-descriptions>
        </template>
      </a-table>
    </div>
    <div v-else-if="currentUser !== 1" class="text-center mt-6">
      <a-typography-paragraph type="secondary">
        Bạn không có quyền truy cập trang này.
      </a-typography-paragraph>
    </div>
    <div v-else class="text-center mt-6">
      <a-typography-paragraph type="secondary">
        Chưa có khách hàng nào đăng ký lái thử.
      </a-typography-paragraph>
    </div>
  </a-card>
</template>

<script>
  import {Card, Descriptions, Table, Typography} from 'ant-design-vue';

  export default {
    components: {
      ACard: Card,
      ATypographyTitle: Typography.Title,
      ATable: Table,
      ATypographyParagraph: Typography.Paragraph,
      ADescriptions: Descriptions,
      ADescriptionsItem: Descriptions.Item,
    },
    data() {
      return {
        currentUser: 1,
        registrations: [
          {
            id: 1,
            customerName: 'Nguyễn Văn A',
            phone: '0901234567',
            email: 'a@example.com',
            carModel: 'Vinfast VF 8',
            carColor: 'Đỏ',
            familyStatus: 'Độc thân',
            hasDriverLicense: true,
            date: '10-01-2024',
          },
          {
            id: 2,
            customerName: 'Trần Thị B',
            phone: '0987654321',
            email: 'b@example.com',
            carModel: 'Mercedes C-Class',
            carColor: 'Xanh',
            familyStatus: 'Đã kết hôn',
            hasDriverLicense: false,
            date: '10-01-2024',
          },
          {
            id: 3,
            customerName: 'Lê Văn C',
            phone: '0987654322',
            email: 'c@example.com',
            carModel: 'BMW X5',
            carColor: 'Trắng',
            familyStatus: 'Ly dị',
            hasDriverLicense: true,
            date: '10-01-2024',
          },
        ],
        columns: [
          {
            title: 'Tên Khách Hàng',
            dataIndex: 'customerName',
            key: 'customerName',
          },
          {
            title: 'Số Điện Thoại',
            dataIndex: 'phone',
            key: 'phone',
          },
          {
            title: 'Xe Đăng Ký',
            dataIndex: 'carModel',
            key: 'carModel',
          },
        ],
      };
    },
    methods: {
      showDetails(record) {
        this.$refs.table.toggleRowExpand(record);
      },
    },
  };
</script>

<style>
  .test-drive-details-user {
    padding: 20px;
  }

  .registration-table {
    margin-top: 10px;
  }
  .test-drive-details-user {
    padding: 20px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
  }

  .test-drive-details-user h2 {
    font-size: 22px;
    color: #333;
    font-weight: bold;
  }

  .registration-table {
    margin-top: 15px;
    border-radius: 8px;
    overflow: hidden;
  }

  /* Bảng */
  .ant-table {
    border-radius: 8px;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
  }

  .ant-table-thead > tr > th {
    background: #f9fafb;
    font-weight: bold;
    padding: 12px;
  }

  .ant-table-tbody > tr > td {
    padding: 10px;
    border-bottom: 1px solid #f1f1f1;
  }

  /* Dòng mở rộng */
  .ant-descriptions-item-label {
    font-weight: bold;
    color: #555;
  }

  .ant-descriptions-item-content {
    color: #222;
  }

  /* Mobile */
  @media (max-width: 768px) {
    .test-drive-details-user {
      padding: 15px;
    }

    .registration-table {
      overflow-x: auto;
    }

    .ant-table {
      font-size: 14px;
    }

    .ant-table-thead > tr > th,
    .ant-table-tbody > tr > td {
      padding: 8px;
    }

    .ant-descriptions-item-label {
      font-size: 14px;
    }
  }
</style>
