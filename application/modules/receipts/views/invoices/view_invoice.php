<!-- DataTables -->
<div class="row">
  <div class="col-12 text-center">
    <h1>Company Name</h1>
    <p>Company Address, Mob: 1234567890</p>
  </div>
  <div class="col-12">
  <table class="table table-bordered table-striped table-sm">
              <tbody>
                  <tr>
                      <td width="25%">Ref. No</td>
                      <td width="25%"><?=$invoice->ref_no; ?></td>
                      <td width="25%">Date</td>
                      <td width="25%"><?= date('d-m-Y', strtotime($invoice->invoice_date)); ?></td>
                  </tr>
                  <tr>
                      <td>Customer</td>
                      <td colspan="3"><?=$invoice->customer_name; ?></td>
                  </tr>
              </tbody>
          </table>
        <table id="example1" class="table table-bordered table-striped table-sm">
          <thead>
            <tr>
              <th width="7%" class="text-center">Sl. No.</th>
              <th class="text-center"> Particulars </th>
              <th width="7%" class="text-center">Unit</th>
              <th width="7%" class="text-center">Qty</th>
              <th width="13%" class="text-center">Rate</th>
              <th width="13%" class="text-center">Total</th>
              <th width="13%" class="text-center">Tax Amount</th>
              <th width="13%" class="text-center">Sub Total</th>
            </tr>
          </thead>
          <tbody id="show_data">
            <?php if ($invoice_line) :
              $sl_no = 1;
            ?>
              <?php foreach ($invoice_line as $value) : ?>
                <tr>
                  <td class="text-center"><?= $sl_no; ?></td>
                  <td><?= $value->products; ?></td>
                  <td class="text-center"><?= $value->unit; ?></td>
                  <td class="text-center"><?= $value->item_qty; ?></td>
                  <td class="text-right"><?= number_format($value->item_rate, 2); ?></td>
                  <td class="text-right"><?= number_format($value->item_total, 2); ?></td>
                  <td class="text-center"><?= $value->tax_percentage; ?></td>
                  <td class="text-right"><?= number_format($value->sub_total, 2); ?></td>
                </tr>
              <?php
                $sl_no++;
              endforeach; ?>
            <?php endif; ?>
          </tbody>
          <tfoot>
              <tr>
                  <th class="text-right" colspan="5">TOTAL</th>
                  <th class="text-right"><?= number_format($invoice->total_value, 2); ?></th>
                  <th class="text-right"><?= number_format($invoice->tax_total_value, 2); ?></th>
                  <th class="text-right"><?= number_format($invoice->grand_total, 2); ?></th>
              </tr>
              <tr>
                  <th class="text-right" colspan="7">Dis. Amt</th>
                  <th class="text-right"><?= number_format($invoice->dis_amount, 2); ?></th>
              </tr>
              <tr>
                  <th class="text-right" colspan="7">Grand Total</th>
                  <th class="text-right"><?= number_format($invoice->total_value, 2); ?></th>
              </tr>
          </tfoot>
        </table>
  </div>
</div>
