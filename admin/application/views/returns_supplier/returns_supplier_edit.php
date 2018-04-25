<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid box" ng-controller="returns_supplier">
        <div class="page-header">
          <h1>แก้ไขใบส่งคืนซัพพลายเออร์</h1>
        </div>
        <div style="padding-top:30px;"></div>
        <form class="form-horizontal" method="POST"  action="<?php echo base_url('returns_supplier/update/'.$returns_supplier_data['id']);?>" accept-charset="utf-8" enctype="multipart/form-data">
        <fieldset>
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-3 control-label" for="id">รหัส</label>
          <div class="col-md-4">
          <input id="returns_supplier_id" name="returns_supplier_id" type="hidden" disabled="true" value="<?php echo $returns_supplier_data['id']; ?>" placeholder="รหัส" class="form-control input-md" required="">
          <input id="doc_no" name="doc_no" type="text" disabled="true" value="<?php echo $returns_supplier_data['doc_no']; ?>" placeholder="รหัส" class="form-control input-md" required="">

          </div>
        </div>


              <!-- Select Basic -->
        <div class="form-group">
          <label class="col-md-3 control-label" for="select_supplier">ผู้ผลิต</label>
          <div class="col-md-4">
            <select id="select_supplier" name="select_supplier"  class="form-control" disabled="true"  readonly>
             <?php if ($returns_supplier_data['supplier_id']== 0 || !isset($returns_supplier_data['supplier_id'])): ?>
                <option value="0" selected>*** ไม่มี ***</option>
                <?php else: ?>
                  <option value="0">*** ไม่มี ***</option>
            <?php endif ?>
          <?php foreach ($supplier_list as $supplier): ?>
              <?php if ($supplier['id']==$returns_supplier_data['supplier_id']): ?>
                <option value="<?php echo $supplier['id']; ?>" selected><?php echo $supplier['name']; ?></option>
              <?php else: ?>
                <option value="<?php echo $supplier['id']; ?>"><?php echo $supplier['name']; ?></option>
              <?php endif ?>
            <?php endforeach ?>
            </select>
          </div>
        </div>


          <!-- Text input-->
          <div class="form-group">
                                <label class="col-md-3 control-label" for="name">เพิ่มสินค้า</label>
                                <div class="col-md-6 well">
                                    <input type="text" class="form-control input-md" ng-model="serial_number"  placeholder="serial number" enter><br />
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
                  <input id="comment" name="comment" type="text" placeholder="หมายเหตุ" class="form-control input-md" value="<?php echo $returns_supplier_data['comment']; ?>" >
              </div>
          </div>

    

        <!-- Multiple Checkboxes -->
        <div class="form-group">
          <label class="col-md-3 control-label" for="isactive">ใช้งาน</label>
          <div class="col-md-4">
          <div class="checkbox">
            <label for="isactive-0">
              <input type="checkbox" name="isactive" id="isactive-0" value="1"
              <?php if($returns_supplier_data['is_active']==1): ?>
                <?php echo "checked"; ?>
              <?php endif ?>
              >
              ใช้งาน
            </label>
            </div>
          </div>
        </div>

        <!-- Button -->
        <div class="form-group">
          <label class="col-md-3 control-label" for="save"></label>
          <div class="col-md-4">
            <button type="submit" class="btn btn-primary">เปลี่ยนแปลงข้อมูล</button>
          </div>
        </div>
        </fieldset>
        </form>
    </div>
    <!-- /.container-fluid -->
  </section>
</div>
<!-- /.content -->
