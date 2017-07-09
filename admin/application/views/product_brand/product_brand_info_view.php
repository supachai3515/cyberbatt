<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      View info Product brands
      <small>กลุ่มเมนูผู้ใช้</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo base_url('product_brand'); ?>"> Product brand</a></li>
      <li class="active">View Product brand</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->

            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">  View info Product brands : (<?php echo $product_brand_data['product_brand_id']; ?>)</h3>
                </div><!-- /.box-header -->
                <!-- form start -->

                <form role="form"  role="form">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control required" id="name" name="name" value="<?php echo $product_brand_data['name']; ?>" maxlength="128" readonly>
                                    <input type="hidden" value="<?php echo $product_brand_data['product_brand_id']; ?>" name="product_brand_id" id="product_brand_id" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <input type="text" class="form-control" id="description"  name="description" value="<?php echo $product_brand_data['description']; ?>" maxlength="1204" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Create By</label>
                                    <input type="text" class="form-control required" id="name" name="name" value="<?php echo $product_brand_data['create_by_name']; ?>" maxlength="128" readonly>
                                    <input type="hidden" value="<?php echo $product_brand_data['product_brand_id']; ?>" name="product_brand_id" id="product_brand_id" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description">Create Date</label>
                                    <input type="text" class="form-control" id="description"  name="description" value="<?php echo $product_brand_data['create_date']; ?>" maxlength="1204" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Modified By</label>
                                    <input type="text" class="form-control required" id="name" name="name" value="<?php echo $product_brand_data['modified_by_name']; ?>" maxlength="128" readonly>
                                    <input type="hidden" value="<?php echo $product_brand_data['product_brand_id']; ?>" name="product_brand_id" id="product_brand_id" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description">Modified Date</label>
                                    <input type="text" class="form-control" id="description"  name="description" value="<?php echo $product_brand_data['modified_date']; ?>" maxlength="1204" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <div class="checkbox">
                                  <label>
                                    <?php if ($product_brand_data['is_active'] == 1): ?>
                                      <input type="checkbox"  id="is_active"  name="is_active" value="1" checked="true" disabled="true"> ใช้งาน
                                    <?php else: ?>
                                      <input type="checkbox"  id="is_active"  name="is_active" value="1" disabled="true"> ใช้งาน
                                    <?php endif; ?>
                                  </label>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </form>
            </div>
        </div>
    </div>
  </section>
  <!-- /.content -->
</div>
