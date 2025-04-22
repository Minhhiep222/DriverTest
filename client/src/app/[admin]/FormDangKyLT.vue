<template>
  <div class="trial-form-container">
    <h2>ĐĂNG KÝ LÁI THỬ XE</h2>
    <form>
      <div class="form-group">
        <label for="ten">Tên <span class="required">*</span></label>
        <input
          type="text"
          id="ten"
          placeholder="Ví dụ: Nguyễn Văn A"
          required />
      </div>
      <div class="form-group">
        <label for="sdt">Số Điện Thoại <span class="required">*</span></label>
        <input
          type="tel"
          id="sdt"
          placeholder="Ví dụ: 0901234567"
          pattern="[0-9]{10,11}"
          required />
      </div>
      <div class="form-group">
        <label for="diachi">Địa Chỉ</label>
        <textarea
          id="diachi"
          placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành phố"></textarea>
      </div>
      <div class="form-group">
        <label for="ghichu">Ghi Chú</label>
        <textarea
          id="ghichu"
          placeholder="Yêu cầu đặc biệt, loại xe quan tâm,..."></textarea>
      </div>
      <div class="form-group">
        <label for="thoigian"
          >Thời Gian Lái (Dự Kiến) <span class="required">*</span></label
        >
        <input type="datetime-local" id="thoigian" required />
      </div>
      <button type="submit" class="submit-button">Đăng Ký Ngay</button>
    </form>
  </div>
</template>

<style>
  .trial-form-container {
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #f9f9f9;
  }

  h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
  }

  label {
    display: block;
    margin-bottom: 5px;
    color: #555;
  }

  input[type='text'],
  input[type='tel'],
  select,
  textarea,
  input[type='number'],
  input[type='datetime-local'] {
    width: calc(100% - 12px);
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
  }

  .radio-group {
    display: flex;
    gap: 10px;
  }

  .radio-group label {
    display: inline-flex;
    align-items: center;
    margin-right: 10px;
  }

  .radio-group input[type='radio'] {
    margin-right: 5px;
  }

  textarea {
    height: 100px;
  }

  .required {
    color: red;
  }

  .submit-button {
    display: block;
    width: 100%;
    padding: 10px;
    background-color: #4caf50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  .submit-button:hover {
    background-color: #45a049;
  }
</style>
