<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid box" ng-controller="mainCtrl">
        <div class="page-header">
            <h1>ใบเสนอราคา</h1>
            <?php //if(isset($sql))echo "<p>".$sql."</p>"; ?>
        </div>
        <form action="<?php echo base_url('quotation/search');?>" method="POST" class="form-inline" role="form">

        <div class="form-group">
                <label class="sr-only" for="">เลขที่ใบสั่งซื้อ</label>
                <input type="number" class="form-control" id="order_id" name="order_id" placeholder="เลขที่ใบสั่งซื้อ">
            </div>

            <div class="form-group">
                <label class="sr-only" for="">เลขที่เอกสาร</label>
                <input type="text" class="form-control" id="search" name="search" placeholder="เลขที่เอกสาร">
            </div>

            <button type="submit" class="btn btn-primary">ค้นหา</button>
        </form>
        <div class="box-body table-responsive no-padding">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Order</th>
                        <th>จำนวน</th>
                        <th>ส่งไปยัง</th>
                        <th>รวม</th>
                        <th>ดู</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($quotation_list as $quotation): ?>
                    <tr>
                        <td>
                        <span class="">เลขที่เอกสาร : <?php echo $quotation['id'];?></span><br/>
                        <?php if (isset($quotation['docno']) && $quotation['docno'] !="") : ?>
                                  <span class=""><?php echo $quotation['docno'];?></span><br/>
                        <?php endif ?>
                        <span>ครบกำหนด : <i class="fa fa-calendar"></i> <?php echo date("d-m-Y", strtotime($quotation['due_date']));?></span><br/>

                        <?php if (isset($quotation['invoice_docno']) && $quotation['invoice_docno'] !="") : ?>
                                  <strong class="label label-info">ใบส่งของ : <?php echo $quotation['invoice_docno'];?></strong><br/>
                        <?php endif ?>

                        </td>
                        <td>
                            <span>เลขที่ใบสั่งซื้อ : <strong>#<?php echo $quotation['order_id'] ?></strong></span><br/>
                            <span>โดย : <strong><?php echo $quotation['name'] ?></strong></span><br/>
                          
                            <span>แก้ไข : <i class="fa fa-calendar"></i> <?php echo date("d-m-Y H:i", strtotime($quotation['modified_date']));?></span>
                                        <br/>
                                        <?php if ($quotation['is_active']=="1"): ?>
                                            <span class="text-success"><i class="fa fa-check"></i> ใช้งาน</span>
                                            <br/>
                                        <?php else: ?>
                                            <span class="text-danger"><i class="fa fa-times"></i> ยกเลิก</span>
                                            <br/>
                                        <?php endif ?>
                        </td>
                        <td>
                            <span><strong><?php echo $quotation['quantity'] ?></strong> item</span><br/>
                        </td>
                        <td>
                            <strong>ที่อยู่ : </strong><span><?php echo $quotation['address']; ?></span><br/>
                            <strong>วิธีการจัดส่ง : </strong><span><?php echo $quotation['shipping']; ?></span><br/>
                            <strong>อีเมลล์ : </strong><span><?php echo $quotation['email']; ?></span><br/>
                            <strong>เบอร์โทร : </strong><span><?php echo $quotation['tel']; ?></span><br/>
                            <?php if ($quotation['is_tax']=="1"): ?>
                                <h4>ออกใบกำภาษี</h4>
                                 <strong>เลขที่ผุ้เสียภาษี : </strong><span><?php echo $quotation['tax_id']; ?></span><br/>
                                 <strong>บริษัท : </strong><span><?php echo $quotation['tax_company']; ?></span><br/>
                                <strong>ที่อยู่ : </strong><span><?php echo $quotation['tax_address']; ?></span><br/>

                            <?php endif ?>

                        </td>

                        <td>
                             <strong ng-bind="<?php echo $quotation['total'];?> | currency:'฿':0"></strong>
                        </td>
                        <td>
                        <a href="<?php echo  base_url('quotation/edit/'.$quotation['id']); ?>" ><button type="button" class="btn btn-sm btn-warning"> <i class="fa fa-pencil"></i></button></a>
                          </a>
                          <a href="<?php echo  base_url('quotation/quotation_invoice/'.$quotation['id']); ?>" ><button type="button" class="btn btn-sm btn-info"> <i class="fa fa-eye"></i></button></a>
                          
                          <a href="<?php echo  base_url('quotation/quotation_invoice_searial/'.$quotation['id']); ?>" ><button type="button" class="btn btn-sm btn-info"> <i class="fa fa-eye"></i> Searial</button>
                        </a>
                           
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <?php if(isset($links_pagination)) {echo $links_pagination;} ?>
    </div>
    <!-- /.container-fluid box -->
</div>
</section>
<!-- /.content -->
