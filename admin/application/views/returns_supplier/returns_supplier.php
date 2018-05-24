<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid box" ng-controller="returns_supplier">
        <div class="page-header">
            <h1>ใบส่งคืนซัพพลายเออร์</h1>
            <?php //if(isset($sql))echo "<p>".$sql."</p>";?>
        </div>
        <div role="tabpanel">
        <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#search" aria-controls="search" role="tab" data-toggle="tab"><i class="fa fa-search"></i> ค้นหาใบส่งคืนซัพพลายเออร์</a>
                </li>
                <li role="presentation">
                    <a href="#add" aria-controls="tab" role="add" data-toggle="tab"><i class="fa fa-plus"></i> เพิ่มใบส่งคืนซัพพลายเออร์</a>
                </li>
            </ul>
             <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="search">
                    <div style="padding-top:30px;"></div>
                    <form action="<?php echo base_url('returns_supplier/search');?>" method="POST" class="form-inline" role="form">
                        <div class="form-group">
                            <label class="sr-only" for="">search</label>
                            <input type="text" class="form-control" id="search" name="search" placeholder="เลขที่เอกสาร" value ="<?php if(isset($data_search['search'])){echo $data_search['search'];}?>">
                        </div>

                         <div class="form-group">
              <label for="select_type">สถานะ</label>
              <select id="select_type" name="select_status" class="form-control">
                <option value="9" <?php if(isset($data_search['select_status']) && $data_search['select_status'] == '9'){echo "selected";}?>>ทั้งหมด</option>
                <option value="1"<?php if(isset($data_search['select_status']) && $data_search['select_status'] == '1'){echo "selected";}?>>ส่งออก</option>
                <option value="2"<?php if(isset($data_search['select_status']) && $data_search['select_status'] == '2'){echo "selected";}?>>รอส่งออก</option>
                <option value="3"<?php if(isset($data_search['select_status']) && $data_search['select_status'] == '3'){echo "selected";}?>>ยกเลิก</option>
                </select>
            </div>

                        <button type="submit" class="btn btn-primary">ค้นหา</button>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>รหัส</th>
                                    <th>ชื่อ</th>
                                    <th>จำนวน</th>
                                    <th>ส่งออก</th>
                                    <th>สถานะ</th>
                                    <th>แก้ไข</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($returns_supplier_list as $returns_supplier): ?>
                                <tr>
                                    <td>
                                        <span>รหัส : <strong><?php echo $returns_supplier['doc_no'] ?></strong></span><br/>
                                        <span>Supplier : <strong><?php echo $returns_supplier['supplier_name'] ?></strong></span><br/>

                                    </td>
                                    <td>
                                        <span>หมายเหตุ : <strong><?php echo $returns_supplier['comment'] ?></strong></span><br/>
                                    </td>
                                    <td>

                                         <span>qty : <strong><?php echo $returns_supplier['qty'] ?></strong></span><br/>
                                           <span>total : <strong><?php echo $returns_supplier['total'] ?></strong></span><br/>

                                    </td>
                                    <td>
                                        <?php if ($returns_supplier['is_export']=="1"): ?>
                                            
                                            <?php if ($returns_supplier['is_export']=="1"): ?>
                                                <span><i class="fa fa-check"></i> ส่งออกแล้ว</span>
                                            <?php endif ?>
                                            <br/>
                                            <span><i class="fa fa-calendar"></i> <?php echo date("d-m-Y H:i", strtotime($returns_supplier['export_date']));?></span>
                                            
                                        <?php endif ?>
                                    </td>

                                    <td>
                                         <span><i class="fa fa-calendar"></i> <?php echo date("d-m-Y H:i", strtotime($returns_supplier['modified_date']));?></span>
                                        <br/>
                                        <?php if ($returns_supplier['is_active']=="1"): ?>
                                            <span><i class="fa fa-check"></i> ใช้งาน</span>
                                            <br/>
                                        <?php else: ?>
                                            <span class="text-danger"><i class="fa fa-times"></i> ยกเลิก</span>
                                            <br/>
                                        <?php endif ?>
                                    </td>
                                    <td>
  									  <a  class="btn btn-sm btn-warning" href="<?php echo base_url('returns_supplier/edit/'.$returns_supplier['id']) ?>" role="button"><i class="fa fa-pencil"></i></a>
                                     <a target="_blank" class="btn btn-sm btn-info" href="<?php echo base_url('returns_supplier/view/'.$returns_supplier['id']) ?>" role="button"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if (isset($links_pagination)) {echo $links_pagination;} ?>
                </div>
                 <div role="tabpanel" class="tab-pane" id="add">
                    <div style="padding-top:30px;"></div>

                    <form class="form-horizontal" method="POST" action="<?php echo base_url('returns_supplier/add');?>" accept-charset="utf-8" enctype="multipart/form-data">
                        <fieldset>
                              <!-- Select Basic -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="select_supplier">ผู้ผลิต</label>
                                    <div class="col-md-4">
                                        <select id="select_supplier" name="select_supplier"  ng-model="select_supplier" class="form-control">
                                        <?php
                                            foreach ($supplier_list as $supplier) {
                                                echo '<option value="'.$supplier["id"].'">'.$supplier["name"].'</option>';
                                            }
                                        ?>
                                        </select>
                                    </div>
                                </div>

                      
                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="name">เพิ่มสินค้า</label>
                                <div class="col-md-6 well">
                                    <input type="text" class="form-control input-md" ng-model="serial_number" placeholder="serial number" enter><br />
                                    <button type="button"  class="btn btn-primary" ng-click="addreturns_supplier()">เพิ่ม</button>
                                    <p class="text-danger">{{msgError}}</p>


                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        serial number
                                                    </th>
                                                    <th>
                                                        name
                                                    </th>
                                                    <th>
                                                        comment
                                                    </th>
                                                    <th>
                                                        qty
                                                    </th>
                                                    <th>
                                                        price
                                                    </th>
                                                    <th>
                                                        total
                                                    </th>
                                                    <th>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="product in product_returns_supplier">
                                                    <td>
                                                        <input type="hidden" name="sku[]" value="{{product.sku}}" >
                                                        <input type="hidden" name="id[]" value="{{product.id}}" >
                                                        <input type="hidden" name="product_id[]" value="{{product.product_id}}" >
                                                        <input type="hidden" name="serial_number[]" value="{{product.serial_number}}" >
                                                        {{ product.serial_number }}
                                                    </td>
                                                    <td>
                                                        {{ product.name }}
                                                    </td>
                                                    <td>
                                                        {{ product.comment }}
                                                    </td>
                                                    <td>
                                                    <input type="hidden" name="qty[]" value="{{product.qty}}" >
                                                        {{ product.qty }}
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="price[]" value="{{product.price }}" >
                                                        {{ product.price | currency:'' }}
                                                    </td>
                                                    <td>
                                                        {{ product.total  | currency:'' }}
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger" ng-click="removeProduct($index)">ลบ</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td>
                                                    </td>
                                                    <td>
                                                    </td>
                                                    <td>
                                                    </td>
                                                    <td>
                                                       <strong> {{ getQtyreturns_supplier() }}</strong>
                                                    </td>
                                                    <td>

                                                    </td>
                                                    <td>
                                                        <strong>{{ getTotalreturns_supplier() | currency:''  }}</strong>
                                                    </td>

                                                    <td>
                                                    </td>

                                                </tr>

                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="comment">หมายเหตุ</label>
                                <div class="col-md-6">
                                    <input id="comment" name="comment" type="text" placeholder="หมายเหตุ" class="form-control input-md">
                                </div>
                            </div>


                            <!-- Multiple Checkboxes -->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="isactive">ใช้งาน</label>
                                <div class="col-md-4">
                                    <div class="checkbox">
                                        <label for="isactive-0">
                                            <input type="checkbox" name="isactive" id="isactive" value="1" checked> ใช้งาน
                                        </label>
                                    </div>
                                </div>
                            </div>
                         
                            <!-- Button -->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="save"></label>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">บันทึก</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
  </section>
</div>
<!-- /.content -->
