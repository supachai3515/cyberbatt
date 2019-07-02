<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid box" ng-controller="mainCtrl">
        <div class="page-header">
          <h1>แก้ไข ใบส่งของ</h1>
        </div>
        <div style="padding-top:30px;"></div>
        <form class="form-horizontal" method="POST"  action="<?php echo base_url('delivery_note/update/'.$delivery_note_data['id']);?>" accept-charset="utf-8" enctype="multipart/form-data">
        <fieldset>
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-3 control-label" for="id">รหัส</label>  
          <div class="col-md-4">
          <input id="id" name="id" type="text" disabled="true" value="<?php echo $delivery_note_data['id']; ?>" placeholder="รหัส" class="form-control input-md" required="">
            
          </div>
        </div>

        <div class="form-group">
              <label class="col-md-3 control-label" for="textinput">วันที่ครบกำหนด  *</label>
                <div class="col-md-6">
                    <div class="input-group date" id="datepicker">
                        <input type="text" class="form-control" name="due_date" placeholder="วันที่" value="<?php if(isset($delivery_note_data['due_date'])) echo date("Y-m-d", strtotime($delivery_note_data['due_date']));?>" required="true">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                   </div>
                  </div>
        <!-- Textarea -->
        <div class="form-group">
          <label class="col-md-3 control-label" for="description">รายละเอียด</label>
          <div class="col-md-8">                     
            <textarea class="form-control" id="detail" name="description"><?php echo $delivery_note_data['description']; ?></textarea>
          </div>
        </div>

        <!-- Multiple Checkboxes -->
        <div class="form-group">
          <label class="col-md-3 control-label" for="isactive">ใช้งาน</label>
          <div class="col-md-4">
          <div class="checkbox">
            <label for="isactive-0">
              <input type="checkbox" name="isactive" id="isactive-0" value="1" 
              <?php if ($delivery_note_data['is_active']==1): ?>
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
            <button type="submit" class="btn btn-primary">บันทึก</button>
          </div>
        </div>
        </fieldset>
        </form>
    </div>
    <!-- /.container-fluid box -->
</div>
</section>
<!-- /.content -->
