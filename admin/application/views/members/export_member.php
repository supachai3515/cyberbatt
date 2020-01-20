<?php
    header("Content-Type: application/vnd.ms-excel");
    header('Content-Disposition: attachment; filename="export_member.xls"');
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
            <th>ชื่อ</th> 
            <th>Username</th> 
            <th>Password</th> 
            <th>Mobile</th> 
            <th>Tel</th> 
            <th>Email</th> 
            <th>ที่อยู่จัดส่งสินค้า</th> 
            <th>ที่อยู่ใบกำกับภาษี</th> 
            <th>Tax number</th> 
            <th>วันที่สมัคร</th> 
            <th>ยืนยัน</th>
            <th>ใช้งาน</th>
            <th>fanshine</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($members_list as $member): ?>
    <tr>
        <td><?php echo $member['first_name'].' '.$member['last_name']; ?>  </td>
        <td><?php echo $member['username']; ?></td>
        <td><?php echo $member['password']; ?></td>
        <td><?php echo $member['mobile']; ?></td>
        <td><?php echo $member['tel']; ?></td>
        <td><?php echo $member['email']; ?></td>
        <td><?php echo $member['address_receipt']; ?></td>
        <td><?php echo $member['address_tax']; ?> </td>
        <td>
            <?php if (isset($member['tax_number'])): ?>
                <?php echo $member['tax_number']; ?> 
            <?php endif ?>
        </td>
        <td><?php echo date("d-m-Y H:i", strtotime($member['date']));?> </td>                            
        <td>                            
            <?php if ($member['verify']=="1"): ?>
                ยืนยันแล้ว  
            <?php else: ?>
                ยังไม่ได้ยืนยัน 
            <?php endif ?>
        </td>
        <td><?php if ($member['is_active']=="1"): ?>ใช้งาน <?php else: ?> ยกเลิก <?php endif ?></td>
        <td><?php if ($member['is_lavel1']=="1"): ?>Dealer fanshine<?php endif ?> </td>
    </tr>
    <?php endforeach ?>
    </tbody>
</table>
</body>
</html>
