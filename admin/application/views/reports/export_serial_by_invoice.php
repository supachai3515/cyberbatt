<?php
    header("Content-Type: application/vnd.ms-excel");
    header('Content-Disposition: attachment; filename="export_serial_by_invoice.xls"');
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<html>
<head>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
</head>
<body>

<table border="1px">
    <thead>
        <tr>
            <th>invoice_docno</th>
            <th>serial number</th>
            <th>เลขที่ใบรับเข้า</th>
            <th>order_id</th>
            <th>order_name</th>
            <th>Address</th>
            <th>sku</th>
            <th>product name</th>
            <th>model</th>
            <th>วันที่ออก invoice</th>
            <th>ใบรับคืน</th>
            <th>ใช้งาน</th>
        </tr>
    </thead>
    <tbody>
      <?php foreach ($serial_by_invoice_report_data as $orders_data): ?>
        <tr>
          <td><?php echo $orders_data['invoice_no'] ?></td>
          <td><?php echo $orders_data['serial_number'] ?></td>
          <td><?php echo $orders_data['receive_doc_no'] ?></td>
          <td><?php echo $orders_data['order_id'] ?></td>
          <td><?php echo $orders_data['order_name'] ?></td>
          <td><?php echo $orders_data['address'] ?></td>
          <td><?php echo $orders_data['sku'] ?></td>
          <td><?php echo $orders_data['product_name'] ?></td>
          <td><?php echo $orders_data['model'] ?></td>
          <td>
              <?php echo date("d-m-Y H:i", strtotime($orders_data['invoice_date']));?>
          </td>
          <td>
          <?php if ($orders_data['is_receive']=="1"): ?>
                  true
                <?php else: ?>
                  false
                <?php endif ?>
          </td>
          <td>
          <?php if ($orders_data['is_invoice']=="1"): ?>
                  true
                <?php else: ?>
                  false
                <?php endif ?>
          </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>
</body>
</html>
