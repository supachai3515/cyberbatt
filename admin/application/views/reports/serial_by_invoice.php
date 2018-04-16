<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid box">
        <div class="page-header">
            <h1> รายงาน serial ตามใบกำภาษี
        </div>
        <div class="row">
            <form action="<?php echo base_url() ?>report_order/serial_by_invoice/1/" method="post" class="form" role="form">
              <fieldset>
                <div class="col-md-6">
                  <div class="form-group">
                    <span id="startDate" style="display:none"><?php echo DATE;?></span>
                      <label for="">จากวันทีใบสั่งซื้อ</label>
                      <input type="text" class="form-control" id="dateStart" name="dateStart" placeholder="วันที่เริ่มต้นค้นหา" value="<?php if(isset($resultpost['dateStart'])){echo ($resultpost['dateStart'] == '' ? DATE : $resultpost['dateStart']);}?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <span id="endDate"></span>
                      <label for="">ถึงวันที่ใบสั่งซื้อ</label>
                      <input type="text" class="form-control" id="dateEnd" name="dateEnd" placeholder="วันที่สิ้นสุดการค้นหา" value="<?php if(isset($resultpost['dateEnd'])){echo ($resultpost['dateEnd'] == '' ? DATE : $resultpost['dateEnd']);}?>">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="search">รหัส + ชื่อ + Serial</label>
                    <input id="search" name="search"  value="<?php if(isset($resultpost['search']))echo $resultpost['search']; ?>" type="text" class="form-control input-md">
                  </div>
                </div>

                <div class="clearfix"></div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="is_export">
                        <input type="checkbox" name="is_export" id="is_hot" value="1"
                        <?php if(isset($data_search['is_export'])) {if($data_search['is_export']==1) echo "checked";} ?>> export to excel
                    </label>
                  </div>
                </div>
                <div class="col-md-6">

                </div>
                <div class="col-md-12">
                  <div class="form-group">
                      <button type="submit" class="btn btn-primary">ค้นหา</button>
                  </div>
                </div>
              </fieldset>
            </form>
            <p> *** วันที่รับคืน
              <?php

              $date  = strtotime('-7 days');
              $obj['dateStart'] = date("Y-m-d",$date );
              $obj['dateEnd'] = date("Y-m-d");

                if (isset($resultpost['dateStart']) && $resultpost['dateStart'] != "") {
                    echo $resultpost['dateStart'].' - '. $resultpost['dateEnd'];
                }
                else {
                  echo $obj['dateStart'] .' - '. $obj['dateEnd'];
                }
              ?> ***</p>
        </div>
        <div class="row">
          <div class="col-md-12">


        
            <div class="box-body table-responsive no-padding">
              <table id="example"  class="table table-hover">  
                <thead>
                  <tr>
                    <th>รหัส</th>
                    <th>รายละเอียด</th>
                    <th>สถานะ</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($serial_by_invoice_report_data as $orders_data): ?>
                    <tr>
                      <td>
                        <span>invoice No. : <strong><?php echo $orders_data['invoice_no'] ?></strong></span>
                        <br/>
                        <span>serial number : <strong><?php echo $orders_data['serial_number'] ?></strong></span>
                        <br/>
                        <span>order : <strong><?php echo $orders_data['order_id'] ?></strong></span>
                      </td>
                      <td>
                        <span>Name : <strong><?php echo $orders_data['order_name'] ?></strong></span>
                        <br/>
                        <span>ที่อยู่จัดส่ง : <strong><?php echo $orders_data['address'] ?></strong></span>
                        <br/>
                        <span>SKU : <strong><?php echo $orders_data['sku'] ?></strong></span>
                        <br/>
                        <span>Product Name : <strong><?php echo $orders_data['product_name'] ?></strong></span>
                        <br/>
                        <span>Model: <strong><?php echo $orders_data['model'] ?></strong></span>
                        <br/>
                      </td>

                      <td>
                    
            
                                <span><i class="fa fa-calendar"></i> <?php echo date("d-m-Y H:i", strtotime($orders_data['invoice_date']));?></span>
                                <br/>
                                <?php if ($orders_data['is_invoice']=="1"): ?>
                                  <span><i class="fa fa-check"></i> ใช้งาน</span>
                                  <br/>
                                  <?php else: ?>
                                    <span class="text-danger"><i class="fa fa-times"></i> ยกเลิก</span>
                                    <br/>
                                    <?php endif ?>
                                    
                                <?php if ($orders_data['is_invoice'] == 1): ?>
                                <a  href="<?php echo  base_url('orders/invoice/'.$orders_data['order_id']); ?>" target="_blank"><button type="button" class="btn btn-info">ใบกำกับภาษี</button></a>
                            <?php endif ?>
                      </td>

                    </tr>
                    <?php endforeach ?>
                </tbody>
              </table>
            </div>
            <div class="box-footer clearfix">
                <?php if(isset($links_pagination)) {echo $links_pagination;} ?>
            </div>
          </div>
        </div>

      </div>
      <!-- /.container-fluid -->
    </section>
  </div>
  <!-- /.content -->
