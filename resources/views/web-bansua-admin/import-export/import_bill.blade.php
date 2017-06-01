
<!doctype html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>In hóa đơn nhập</title>
  <style>
    body, h1, div, th, td, p { font-family: DejaVu Sans, sans-serif;  }
  </style>

  <style>
    .clearfix:after {
  content: "";
  display: table;
  clear: both;
}

a {
  color: #5D6975;
  text-decoration: underline;
}

body {
  position: relative;
  width: 21cm;  
  height: 29.7cm; 
  margin: 0 auto; 
  color: #001028;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 12px; 
  font-family: Arial;
}

header {
  padding: 10px 0;
  margin-bottom: 30px;
}

#logo {
  text-align: center;
  margin-bottom: 10px;
}

#logo img {
  width: 90px;
}

h1 {
  color: #5D6975;
  font-size: 2.4em;
  line-height: 1.4em;
  font-weight: normal;
  text-align: center;
  margin: 0 0 20px 0;
  background: ;
}

#project {
  float: left;
}

#project span {
  color: #5D6975;
  text-align: right;
  width: 60px;
  margin-right: 30px;
  display: inline-block;
  font-size: 0.8em;
}

#company {
  float: left;
  text-align: left;
}

#project div,
#company div {
  white-space: nowrap;        
}

table {
  width: 92%;
  float: center;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
}

table tr:nth-child(2n-1) td {
  background: #F5F5F5;
}

table th,
table td {
  text-align: center;
}

table th {
  padding: 3px 15px;
  color: #5D6975;
  border-bottom: 1px solid #C1CED9;
  white-space: nowrap;        
  font-weight: normal;
}

table .service,
table .desc {
  text-align: left;
}

table td {
  padding: 10px;
  text-align: right;
}

table td.service,
table td.desc {
  vertical-align: top;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table td.grand {
  border-top: 1px solid #5D6975;
}

#notices .notice {
  color: #5D6975;
  font-size: 1.2em;
}

footer {
  color: #5D6975;
  width: 92%;
  height: 80px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #C1CED9;
  padding: 8px 0;
  text-align: center;
}
.whatever { page-break-after: always; }
  </style>
</head>

<body>
    @foreach($orders as $order)
    <header class="clearfix">
      <div>SỮA VIỆT NAM
      
      <div style="text-align: right; float: right;  margin-right: 120px;">Mã HĐ: {{$order->id}}<br/><span>Ngày  tháng  năm</span></div></div>
      <br/>
      <center><h1>HÓA ĐƠN NHẬP HÀNG</h1></center>
      <!-- <center><p style="font-size: 9;">Ngày tháng năm </p></center> -->
      <br/>
      
      <div id="company" class="clearfix">
        <div>Số 100 Đại Cồ Việt,<br/> Hai Bà Trưng, Hà Nội</div>
        <div>Điện thoại: (04) 37786456</div>
        <div>Fax: 04 3766 7704</div>
      </div>

      <div style="text-align: center; float: left;" >
        <div style="font-size: 12">Thông tin nhà cung cấp</div>
        <div>Tên nhà cung cấp: {{$order->ten}}</div>
        <div>Điện thoại: {{$order->sdt}}</div>
        <div>Địa chỉ: {{$order->diachi}}</div>
      </div>
    </header>
    <br/><br/><br/><br/><br/><br/>
    <main>
      <table>
        <thead>
          <tr>
            <th class="service">STT</th>
            <th class="desc">Tên hàng hóa, dịch vụ</th>
            <th>Giá bán</th>
            <th>Số lượng</th>
            <th>Thành tiền</th>
          </tr>
        </thead>
        <tbody>
          <?php $STT=0 ?>
          @foreach($orderDetails as $orderDetail)
          <tr>
            <td class="service"><?php echo ++$STT ?></td>
            <td class="desc">{{ $orderDetail->name }}</td>
            <td class="unit"><center><?php echo number_format($orderDetail->gianhap).' ' ?><u>đ</u></center></td>
            <td class="qty"><center>{{ $orderDetail->soluong }}</center></td>
            <td class="total"><center><?php echo number_format($orderDetail->gianhap * $orderDetail->soluong).' ' ?><u>đ</u></center></td>
          </tr>
          @endforeach
     
          <tr>
            <td colspan="4" class="grand total">SỐ TIỀN CẦN THANH TOÁN</td>
            <td class="grand total"><?php echo number_format($order->total_import).' ' ?><u>đ</u></td>
          </tr>
        </tbody>
      </table>
      
      
    </main>
    <footer>
      <div class="clearfix">
      <div style="text-align: left; float: right">
        <div style=";font-size: 10;"><b>Đại diện nhà cung cấp<b></div>
        <div style=";font-size: 8;">(Ký, ghi rõ họ tên)</div>
      </div>
      <div style="text-align: right;">
        <div style=";font-size: 10;"><b>Thủ kho<b></div>
        <div style=";font-size: 8;">(Ký, ghi rõ họ tên)</div>
      </div>
      
    </footer>
    @endforeach
  </body>
</html>