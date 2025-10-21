<?php 
  require ("fpdf/fpdf.php");
  require ("word.php");
  require "config.php";
  session_start();
  
  
  if(!isset($_SESSION['login'])){
    header("location: login.php");
}

  
  $registered_users=[
    "comname"=>"",
    "comaddress"=>"",
    "comemail"=>"",
    "cphone"=>"",
    "GSTIN"=>"",
    "Image" =>"",
    "signc" =>"",
    "TermsConditions" =>"",
    "TermsConditions1" =>"",
    "TermsConditions2" =>"",
    "TermsConditions3" =>"",
    "TermsConditions4" =>""
  ];

  $sql_select_registered_users = "select * from registered_users where ID = '" . $_SESSION['ID'] . "'";
  $res1=$con->query($sql_select_registered_users);
 if($res1->num_rows>0){
	  $row=$res1->fetch_assoc();
		  $registered_users=[
	  "comname"=>$row["comname"],
      "comaddress"=>$row["comaddress"],
	  "comemail"=>$row["comemail"],
      "cphone"=>$row["cphone"],
      "GSTIN"=>$row["GSTIN"],
      "Image" =>$row["Image"],
      "signc" =>$row["signc"]
    //   "TermsConditions" =>$row["TermsConditions"],
    //   "TermsConditions1" =>$row["TermsConditions1"],
    //   "TermsConditions2" =>$row["TermsConditions2"],
    //   "TermsConditions3" =>$row["TermsConditions3"],
    //   "TermsConditions4" =>$row["TermsConditions4"]
      ];
    }
    // $info = getimagesize(Image);
  //customer and invoice details
  $info=[
    "customer"=>"",
    "address"=>",",
    "city"=>"",
    "sname"=>"",
    "saddress"=>"",
    "scity"=>"",
    "challan_no"=>"",
    "challan_date"=>"",
    "total_amt"=>"",
    "tandc"=>"",
    "words"=>"",
    "placesupply"=>"",
    // "itype"=>"",
    "customeremail"=>"",
    "transportmode"=>"",
    "vehiclenumber"=>""
  ];
  
  //Select Invoice Details From Database
  $sql="select * from purchase where SID='{$_GET["id"]}'";
  $res=$con->query($sql);
  if($res->num_rows>0){
	  $row=$res->fetch_assoc();
	  
	  $obj=new IndianCurrency($row["GRAND_TOTAL"]);
	 

	  $info=[
		"customer"=>$row["CNAME"],
		"address"=>$row["CADDRESS"],
		"city"=>$row["CCITY"],
		"invoice_no"=>$row["INVOICE_NO"],
        "tandc"=>$row["tandc"],
		"invoice_date"=>date("d-m-Y",strtotime($row["INVOICE_DATE"])),
        "start_date"=>date("d-m-Y",strtotime($row["start_date"])),
        "end_date"=>date("d-m-Y",strtotime($row["end_date"])),
        "qref"=>$row["qref"],
        "cperson"=>$row["cperson"],
		"total_amt"=>$row["GRAND_TOTAL"],
		"words"=> $obj->get_words(),
        "placesupply"=>$row["PLACESUPPLY"],
        "customeremail"=>$row["customeremail"]
	  ];
  }
  
  //invoice Products
  $products_info=[
    //   "sgst"=>"",
    //   "cgst"=>""
      ];
  
  //Select Invoice Product Details From Database
  $sql="select * from purchase_products where SID='{$_GET["id"]}'";
  $res=$con->query($sql);
  if($res->num_rows>0){
	  while($row=$res->fetch_assoc()){
		   $products_info[]=[
			"name"=>$row["PNAME"],
            "hsn"=>$row["hsn"],
			"price"=>$row["PRICE"],
            "unit"=>$row["unit"],
			"qty"=>$row["QTY"],
            "sgst"=>$row["sgst"],
            "cgst"=>$row["cgst"],
			"total"=>$row["TOTAL"]
      ];
	  }
  }
  
   
  class PDF extends FPDF
  {
    
    function body($registered_users,$info,$products_info){
      
      
        
        $this->Image($registered_users["Image"],10,15,15,15);
        $this->SetFont('Arial','B',14);
        $this->Cell(20);
        $this->Cell(50,10,$registered_users["comname"],0,1);
        $this->SetFont('Arial','',12);
        $this->Cell(20);
        $this->Cell(50,7,$registered_users["comaddress"],0,1);
        $this->Cell(20);
        $this->Cell(50,7,$registered_users["comemail"],0,1);
        $this->Cell(20);
        $this->Cell(50,7,$registered_users["cphone"],0,1);
        $this->Cell(20);
        $this->Cell(50,7,$registered_users["GSTIN"],0,1);
      
        //Display Invoice Type
        $this->SetY(0);
        $this->SetX(-50);
        $this->SetFont('Arial','',10);
        // $this->MultiCell(50,10,$info["itype"]);

        // Draw First Horizontal Line

        $this->Line(0,8,210,8);

        //Display INVOICE text
        $this->SetY(15);
        $this->SetX(150);
        $this->SetFont('Arial','B',18);
        $this->Cell(50,25,"Purchase Order",0,1);
        
        //Display Horizontal line
        $this->Line(0,48,210,48);

      //Billing Details
      $this->SetY(55);
      $this->SetX(10);
    //   $this->SetFont('Arial','B',12);
    //   $this->Cell(50,10,"To: ",0,1);
      $this->SetFont('Arial','',12);
      $this->Cell(50,7,"Vendor Name : ".$info["customer"],0,1);
      $this->Cell(50,7,"Vendor Address: ".$info["address"],0,1);
      $this->Cell(50,7,$info["city"],0,1);
      $this->Cell(50,7,"Order Start Date : ".$info["start_date"],0,1);
      $this->Cell(50,7,"Order End Date : ".$info["end_date"],0,1);
      $this->Cell(50,7,"Quotation Ref. : ".$info["qref"],0,1);
      $this->Cell(50,7,"Contact Person :".$info["cperson"],0,1);
    //   $this->SetFont('Arial','B',12);
    //   $this->Cell(50,10,"Ship To: ",0,1);
    //   $this->SetFont('Arial','',12);
    //   $this->Cell(50,7,$info["sname"],0,1);
    //   $this->Cell(50,7,$info["saddress"],0,1);
    //   $this->Cell(50,7,$info["scity"],0,1);
      
      //Display Invoice no
      $this->SetY(55);
      $this->SetX(-60);
      $this->Cell(50,7,"Order No. : ".$info["invoice_no"]);
      
      //Display Invoice date
      $this->SetY(63);
      $this->SetX(-60);
      $this->Cell(50,7,"Order Date : ".$info["invoice_date"]);

      //Display Place of Supply
      $this->SetY(71);
      $this->SetX(-60);
      $this->MultiCell(50,7,"Place of Supply : ".$info["placesupply"]);
      
      //Display Table headings
      $this->SetY(130);
      $this->SetX(10);
      $this->SetFont('Arial','B',10);
      $this->Cell(10,9,"S.No",1,0,"C");
      $this->Cell(49,9,"DESCRIPTION",1,0,"C");
      $this->Cell(14,9,"HSN",1,0,"C");
      $this->Cell(10,9,"Unit",1,0,"C");
      $this->Cell(30,9,"PRICE",1,0,"C");
      $this->Cell(24,9,"QTY",1,0,"C");
      $this->Cell(10,9,"SGST",1,0,"C");
      $this->Cell(10,9,"CGST",1,0,"C");
      $this->Cell(33,9,"TOTAL",1,1,"C");
      // $this->SetFont('Arial','',12);
      

      $this->SetWidths(array(10,49,14,10,30,24,10,10,33));
      $this->aligns = array ('C','L','C','C','C','C','C','C','C');
      $this->SetFont('Arial','',9);
      //   $this->formats = array (0,0,0,0);
      $this->SetLineHeight(8);
    //   $this->SetXY(10,0);
    


      $cnt=1;
      // $this->SetFillColor(100,100,100);
      $total_price = 0.00;
      $total_sgst = 0.00;
      $total_cgst = 0.00;
      
      foreach ($products_info as $row) {
          $this->Row(array(
              $cnt++,
              $row["name"],
              $row["hsn"],
              $row["unit"],
              $row["price"],
              $row["qty"],
              $row["sgst"],
              $row["cgst"],
              $row["total"]
          ));
      
          // Calculate totals for each row
          $total_price += $row["price"] * $row["qty"];
          $total_sgst += ($row["sgst"] / 100) * ($row["price"] * $row["qty"]);
          $total_cgst += ($row["cgst"] / 100) * ($row["price"] * $row["qty"]);
      }
      
      // Display table total row
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(157, 9, "TOTAL", 1, 0, "R");
      $this->Cell(33, 9, number_format($total_price, 2), 1, 1, "R");
      $this->Cell(157, 9, "SGST", 1, 0, "R");
      $this->Cell(33, 9, number_format($total_sgst, 2), 1, 1, "R");
      $this->Cell(157, 9, "CGST", 1, 0, "R");
      $this->Cell(33, 9, number_format($total_cgst, 2), 1, 1, "R");
      $this->Cell(157, 9, "GRAND TOTAL", 1, 0, "R");
      $this->Cell(33, 9, number_format($info["total_amt"], 2), 1, 1, "R");



      
      //Display amount in words
 
      $this->SetFont('Arial','',12);
      $this->MultiCell(0,9,'Amount in Words :'   .$info["words"],1,1);
    //   $this->SetFont('Arial','',12);
    //   $this->MultiCell(0,9,$info["words"],0,1);
      
      $this->SetFont('Arial','B',10);
      $this->Cell(0, 10, "Terms & Conditions:", 'LR', 1, 'L');
      $this->SetFont('Arial','',10);
      $this->MultiCell(0, 5, $info["tandc"], 'LR');
    //   $this->MultiCell(0, 5, $registered_users["TermsConditions"], 'LR');
    //   $this->MultiCell(0, 5, $registered_users["TermsConditions1"], 'LR');
    //   $this->MultiCell(0, 5, $registered_users["TermsConditions2"], 'LR');
    //   $this->MultiCell(0, 5, $registered_users["TermsConditions3"], 'LR');
    //   $this->MultiCell(0, 5, $registered_users["TermsConditions4"], 'LRB');
     
    //   $this->SetY(-56);
    //   $this->SetFont('Arial','B',12);
      
    //   $this->MultiCell(0,7,"for................" .$registered_users["comname"] ."\n \n \n Authorized Signatory",0,'R');
    //   $this->Cell(0,7,$this->Image($registered_users["signc"],165,247,20,15),0,'R');


    // $signatureY = $this->GetY() + 10;

    // Move to next page
    $this->SetFont('Arial', 'B', 12);
    $this->MultiCell(0, 10, "for................" . $registered_users["comname"],'LR','R');
    $this->MultiCell(0, 10, $this->Image($registered_users["signc"], 165, $this->GetY(), 20, 15),'LR','R');
    // $this->SetY($this->GetY() + 7); // Adjust Y-coordinate
    $this->MultiCell(0, 22, "Authorized Signatory",'LRB','R');  
    
    // $this->Line(10, $this->GetY() + 7, 200, $this->GetY() + 7); // Bottom line
    // $this->Line(10, $this->GetY() - 28, 10, $this->GetY() + 7); // Left line
    // $this->Line(200, $this->GetY() - 28, 200, $this->GetY() + 7); // Right line
      //Display Footer Text
      

    }
    function Footer()
    {
        // Go to 1.5 cm from bottom
        $this->SetY(-15);
        // Select Arial italic 8
        
        
        $this->SetFont('Arial','',9);
        // Print centered page number
        $this->Cell(0,7,"This is a Computer Generated Invoice",0,1,"C");
        $this->SetFont('Arial','',8);
        $this->Cell(0,7,'Page '.$this->PageNo(). ' of {nb}',0,0,'C');
    }
  
  }
  //Create A4 Page with Portrait 
  $pdf=new PDF("P","mm","A4");

  $pdf->AliasNbPages();

  $pdf->AddPage();
  $pdf->body($registered_users,$info,$products_info); 
  
  
  $filepath= "uploads/";
  $filename= $info["customer"].'_purchase.pdf';
  
  if($_GET['ACTION']=='EMAIL'){
    
    header("location: records-purchase.php");
    
    $pdf->Output($filepath.$filename,'F');
              
              require('phpmailer/src/PHPMailer.php');
	          require('phpmailer/src/SMTP.php');
		      require('phpmailer/src/Exception.php');
                $mail = new \PHPMailer\PHPMailer\PHPMailer();
		        $mail->isSMTP();
                $mail->Host = 'mail.billingbizz.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'no-reply@billingbizz.com';
                $mail->Password = 'Amit@23012345';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->setFrom("no-reply@billingbizz.com", "BillingBizz");
                $mail->addAddress($info["customeremail"]);
                $mail->isHTML(true);
                $mail->Subject = "Purchase Order from BillingBizz";
                $mail->Body = "Hi, Please Find Attached Purchase Order";
                $mail->AddAttachment($filepath.$filename);
                $result=$mail->Send();
                return $result; 
                
  
  }
  
  if($_GET['ACTION']=='DOWNLOAD'){
      $pdf->Output($filename,'D');
  }
  
    if($_GET['ACTION']=='VIEW'){
      $pdf->Output($filename,'I');
  }
  
  if($_GET['ACTION']=='DELETE'){
      $sql= "DELETE from purchase where SID ='{$_GET["id"]}'";
      if ($con->query($sql) === TRUE) {
          header("location: records-purchase.php");
        } else {
            echo "Error deleting record: ";
        }
   
       
   }
  
                
?>