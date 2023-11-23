<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Invoice</title>
  <link rel="stylesheet" href="style.css">
  <link rel="license" href="http://www.opensource.org/licenses/mit-license/">
  <script src="script.js"></script>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <title>CCML</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/cloud-admin.css" media="screen,print" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/themes/default.css" media="screen,print" id="skin-switcher" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/responsive.css" media="screen,print" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/custom.css" media="screen,print" />


  <style>
    body {
      background: rgb(204, 204, 204);
    }

    page {
      background: white;
      display: block;
      margin: 0 auto;
      margin-bottom: 0.5cm;
      box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
    }

    page[size="A4"] {
      width: 21cm;
      /* height: 29.7cm;  */
      height: auto;
    }

    page[size="A4"][layout="landscape"] {
      width: 29.7cm;
      height: 21cm;
    }

    page[size="A3"] {
      width: 29.7cm;
      height: 42cm;
    }

    page[size="A3"][layout="landscape"] {
      width: 42cm;
      height: 29.7cm;
    }

    page[size="A5"] {
      width: 14.8cm;
      height: 21cm;
    }

    page[size="A5"][layout="landscape"] {
      width: 21cm;
      height: 14.8cm;
    }

    @media print {

      body,
      page {
        margin: 0;
        box-shadow: 0;
        color: black;
      }



    }


    .table1>thead>tr>th,
    .table1>tbody>tr>th,
    .table1>tfoot>tr>th,
    .table1>thead>tr>td,
    .table1>tbody>tr>td,
    .table1>tfoot>tr>td {
      border: 1px solid black;
      padding: 2px !important;
    }
  </style>
</head>

<body style="margin: 0px auto !important">
  <page size='A4'>
    <div style="padding: 1px; padding-top:10px;  padding-left:10px; padding-right:10px; ">

      <table>
        <tr>
          <td style="padding:0 15px ;">
            <table class="table  table1 table3">
              <tr>
                <td style="text-align: center;">
                  Bank Copy
                </td>
              </tr>
              <tr>
                <td>
                  <table style="width: 100%;">
                    <tr>
                      <td><img src="<?php echo site_url("assets/gcmhs.png") ?>" width="50">
                      </td>
                      <td style="text-align: center;">
                        <strong>Govt Centennial Model <br />High School Chitral</strong>
                        <br />
                        FEE RECEIPT

                      </td>

                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td>
                  <table style="width: 100%;">
                    <tr>
                      <td><img src="<?php echo site_url("assets/bok_log.png") ?>" width="50">
                      </td>
                      <td style="text-align: center;">
                        <strong>
                          The Bank of Khyber</strong>
                        </br />
                        Main Branch, Attaliq Chowk, Chitral
                      </td>

                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td>Account No: <br /><strong>PK04 KHYB 0011 0000 0107 9000 </strong></td>
              </tr>
              <tr>
                <td>
                  <table style="width: 100%;">
                    <tr>
                      <th style="width: 50%;">Session: <?php echo $bank_challan->session; ?>
                      </th>
                      <th style="text-align: right;">Receipt No: <?php echo $bank_challan->receipt_id; ?>
                      </th>
                    </tr>
                    <tr>
                      <td>Admission No:</td>
                      <td><?php echo $bank_challan->admission_no; ?></td>
                    </tr>
                    <tr>
                      <td>Student Name:</td>
                      <td><?php echo $bank_challan->student_name; ?></td>
                    </tr>
                    <tr>
                      <td>Father Name:</td>
                      <td><?php echo $bank_challan->father_name; ?></td>
                    </tr>
                    <tr>
                      <td>Class / Section:</td>
                      <td><?php echo $bank_challan->class . " / " . $bank_challan->section; ?></td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td style="vertical-align: middle;">
                  <table class="table table-bordered table1">
                    <tr>
                      <th>S.No</th>
                      <th>Heads</th>
                      <th>Amount</th>
                    </tr>
                    <?php
                    $count = 1;
                    $query = "SELECT bank_challan_amounts.*,bank_challan_heads.head  FROM bank_challan_amounts 
                              INNER JOIN bank_challan_heads ON (bank_challan_heads.head_id = bank_challan_amounts.head_id)
                              WHERE bank_challan_amounts.receipt_id = $bank_challan->receipt_id";
                    $heads = $this->db->query($query)->result();
                    foreach ($heads as $head) { ?>
                      <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $head->head; ?></td>
                        <td style="text-align: center;"><?php echo $head->amount; ?></td>
                      </tr>
                    <?php } ?>
                    <tr>
                      <td colspan="2" style="text-align: right;">Total</td>
                      <td style="text-align: center;"><?php echo $bank_challan->total_amount; ?></td>
                    </tr>
                  </table>
                  <br />
                  <br />
                  <br />
                  <br />


                </td>
              </tr>
              <tr>
                <td style="text-align: center;">

                  بنک اوقاتِ کار : صبح 9 بجے تا دوپہر 3 بجے
                  <br />
                  Office contact # 0943412501

                </td>
              </tr>
            </table>
          </td>
          <td>
            <table class="table table1">
              <tr>
                <td style="text-align: center;">
                  Office Copy
                </td>
              </tr>
              <tr>
                <td>
                  <table style="width: 100%;">
                    <tr>
                      <td><img src="<?php echo site_url("assets/gcmhs.png") ?>" width="50">
                      </td>
                      <td style="text-align: center;">
                        <strong>Govt Centennial Model <br />High School Chitral</strong>
                        <br />
                        FEE RECEIPT

                      </td>

                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td>
                  <table style="width: 100%;">
                    <tr>
                      <td><img src="<?php echo site_url("assets/bok_log.png") ?>" width="50">
                      </td>
                      <td style="text-align: center;">
                        <strong>
                          The Bank of Khyber</strong>
                        </br />
                        Main Branch, Attaliq Chowk, Chitral
                      </td>

                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td>Account No: <br /><strong>PK04 KHYB 0011 0000 0107 9000 </strong></td>
              </tr>
              <tr>
                <td>
                  <table style="width: 100%;">
                    <tr>
                      <th style="width: 50%;">Session: <?php echo $bank_challan->session; ?>
                      </th>
                      <th style="text-align: right;">Receipt No: <?php echo $bank_challan->receipt_id; ?>
                      </th>
                    </tr>
                    <tr>
                      <td>Admission No:</td>
                      <td><?php echo $bank_challan->admission_no; ?></td>
                    </tr>
                    <tr>
                      <td>Student Name:</td>
                      <td><?php echo $bank_challan->student_name; ?></td>
                    </tr>
                    <tr>
                      <td>Father Name:</td>
                      <td><?php echo $bank_challan->father_name; ?></td>
                    </tr>
                    <tr>
                      <td>Class / Section:</td>
                      <td><?php echo $bank_challan->class . " / " . $bank_challan->section; ?></td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td style="vertical-align: middle;">
                  <table class="table table-bordered table1">
                    <tr>
                      <th>S.No</th>
                      <th>Heads</th>
                      <th>Amount</th>
                    </tr>
                    <?php
                    $count = 1;
                    $query = "SELECT bank_challan_amounts.*,bank_challan_heads.head  FROM bank_challan_amounts 
                              INNER JOIN bank_challan_heads ON (bank_challan_heads.head_id = bank_challan_amounts.head_id)
                              WHERE bank_challan_amounts.receipt_id = $bank_challan->receipt_id";
                    $heads = $this->db->query($query)->result();
                    foreach ($heads as $head) { ?>
                      <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $head->head; ?></td>
                        <td style="text-align: center;"><?php echo $head->amount; ?></td>
                      </tr>
                    <?php } ?>
                    <tr>
                      <td colspan="2" style="text-align: right;">Total</td>
                      <td style="text-align: center;"><?php echo $bank_challan->total_amount; ?></td>
                    </tr>
                  </table>
                  <br />
                  <br />
                  <br />
                  <br />


                </td>
              </tr>
              <tr>
                <td style="text-align: center;">

                  بنک اوقاتِ کار : صبح 9 بجے تا دوپہر 3 بجے
                  <br />
                  Office contact # 0943412501

                </td>
              </tr>
            </table>
          </td>
          <td style="padding:0 15px ;">
            <table class="table  table1">
              <tr>
                <td style="text-align: center;">
                  Student Copy
                </td>
              </tr>
              <tr>
                <td>
                  <table style="width: 100%;">
                    <tr>
                      <td><img src="<?php echo site_url("assets/gcmhs.png") ?>" width="50">
                      </td>
                      <td style="text-align: center;">
                        <strong>Govt Centennial Model <br />High School Chitral</strong>
                        <br />
                        FEE RECEIPT

                      </td>

                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td>
                  <table style="width: 100%;">
                    <tr>
                      <td><img src="<?php echo site_url("assets/bok_log.png") ?>" width="50">
                      </td>
                      <td style="text-align: center;">
                        <strong>
                          The Bank of Khyber</strong>
                        </br />
                        Main Branch, Attaliq Chowk, Chitral
                      </td>

                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td>Account No: <br /><strong>PK09 KHYB 0011 0020 0120 3487</strong></td>
              </tr>
              <tr>
                <td>
                  <table style="width: 100%;">
                    <tr>
                      <th style="width: 50%;">Session: <?php echo $bank_challan->session; ?>
                      </th>
                      <th style="text-align: right;">Receipt No: <?php echo $bank_challan->receipt_id; ?>
                      </th>
                    </tr>
                    <tr>
                      <td>Admission No:</td>
                      <td><?php echo $bank_challan->admission_no; ?></td>
                    </tr>
                    <tr>
                      <td>Student Name:</td>
                      <td><?php echo $bank_challan->student_name; ?></td>
                    </tr>
                    <tr>
                      <td>Father Name:</td>
                      <td><?php echo $bank_challan->father_name; ?></td>
                    </tr>
                    <tr>
                      <td>Class / Section:</td>
                      <td><?php echo $bank_challan->class . " / " . $bank_challan->section; ?></td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td style="vertical-align: middle;">
                  <table class="table table-bordered table1">
                    <tr>
                      <th>S.No</th>
                      <th>Heads</th>
                      <th>Amount</th>
                    </tr>
                    <?php
                    $count = 1;
                    $query = "SELECT bank_challan_amounts.*,bank_challan_heads.head  FROM bank_challan_amounts 
                              INNER JOIN bank_challan_heads ON (bank_challan_heads.head_id = bank_challan_amounts.head_id)
                              WHERE bank_challan_amounts.receipt_id = $bank_challan->receipt_id";
                    $heads = $this->db->query($query)->result();
                    foreach ($heads as $head) { ?>
                      <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $head->head; ?></td>
                        <td style="text-align: center;"><?php echo $head->amount; ?></td>
                      </tr>
                    <?php } ?>
                    <tr>
                      <td colspan="2" style="text-align: right;">Total</td>
                      <td style="text-align: center;"><?php echo $bank_challan->total_amount; ?></td>
                    </tr>
                  </table>
                  <br />
                  <br />
                  <br />
                  <br />


                </td>
              </tr>
              <tr>
                <td style="text-align: center;">

                  بنک اوقاتِ کار : صبح 9 بجے تا دوپہر 3 بجے
                  <br />
                  Office contact # 0943412501

                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </div>

  </page>

</body>




</html>