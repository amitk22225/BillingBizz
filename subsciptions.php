<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
* {
  box-sizing: border-box;
}

.columns {
  float: left;
  width: 33.3%;
  padding: 8px;
}

.price {
  list-style-type: none;
  border: 1px solid #eee;
  margin: 0;
  padding: 0;
  -webkit-transition: 0.3s;
  transition: 0.3s;
}

.price:hover {
  box-shadow: 0 8px 12px 0 rgba(0,0,0,0.2)
}

.price .header {
  background-color: #111;
  color: white;
  font-size: 25px;
}

.price li {
  border-bottom: 1px solid #eee;
  padding: 20px;
  text-align: center;
}

.price .grey {
  background-color: #eee;
  font-size: 20px;
}

.button {
  background-color: #04AA6D;
  border: none;
  color: white;
  padding: 10px 25px;
  text-align: center;
  text-decoration: none;
  font-size: 18px;
}

@media only screen and (max-width: 600px) {
  .columns {
    width: 100%;
  }
}
</style>
</head>
<body>

<h2 style="text-align:center">Your 14 days free trial has expired please proceed with any one plan to continue using the services</h2>
<br>
<div class="columns">
  <ul class="price">
    <li class="header">Quaterly Plan</li>
    <li class="grey">₹ 99.00 / 3 months</li>
    <li>Unlimited Invoices</li>
    <li>Unlimited Delivery Challan</li>
    <li>Unlimited Purchase Orders</li>
    <li>Unlimited Quotations</li>
    <li>Send records over Email</li>
    <li>24/7 Customer Support</li>
    <li class="grey"><a href="checkout1.php" class="button">Subscribe</a></li>
  </ul>
</div>

<div class="columns">
  <ul class="price">
    <li class="header" style="background-color:#04AA6D">Per Month Plan</li>
    <li class="grey">₹ 29.00 / month</li>
    <li>Unlimited Invoices</li>
    <li>Unlimited Delivery Challan</li>
    <li>Unlimited Purchase Orders</li>
    <li>Unlimited Quotations</li>
    <li>Send records over Email</li>
    <li>24/7 Customer Support</li>
    <li class="grey"><a href="checkout.php" class="button">Subscribe</a></li>
  </ul>
</div>

<div class="columns">
  <ul class="price">
    <li class="header">Per Year Plan</li>
    <li class="grey">₹ 299.00 / Year</li>
    <li>Unlimited Invoices</li>
    <li>Unlimited Delivery Challan</li>
    <li>Unlimited Purchase Orders</li>
    <li>Unlimited Quotations</li>
    <li>Send records over Email</li>
    <li>24/7 Customer Support</li>
    <li>Free GST Filling</li>
    <li class="grey"><a href="checkout3.php" class="button">Subscribe</a></li>
  </ul>
</div>

</body>
</html>
