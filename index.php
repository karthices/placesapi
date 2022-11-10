<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Maps test</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet" />
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js" ></script>
</head>
<body>
  <div class="container">
    <div class="row">
      <br/>
      <div class="col-md-12">
        <div class="col-md-4 form-group">
            <input type="text" name="placeid" id="placeidtext" class="search form-control" placeholder="What you looking for?">
        </div>
        <div class="col-md-4 form-group">
        <button type="button" class="btn btn-success" id="getplace" >Get Business</button>
        </div>
      </div>
    </div>
<span class="counter pull-right"></span>
<table class="table table-hover table-bordered results" id="myplaceids">
  <thead>
    <tr>
      <th>#</th>
      <th class="col-md-3 col-xs-12">Name</th>
      <th class="col-md-3 col-xs-12">Address</th>
      <th class="col-md-3 col-xs-12">Place ID</th>
      <th class="col-md-3 col-xs-12">Contact No.</th>
    </tr>

  </thead>
  <tbody>
    
  </tbody>
</table>
</div>

<script type="text/javascript">
const getplaceids = document.getElementById("getplace");
const placeidtext = document.getElementById("placeidtext");


const getPlaceDetails = function(placeid, rno){

var requestOptions = {
  method: 'POST',
  redirect: 'follow',
  body: JSON.stringify({'placeid':placeid,'key':'getno'})
};

fetch('operations.php', requestOptions)
  .then((response) => response.json())
  .then((response) => {
    if(response && response.status && response.data && document.querySelectorAll("[data-id='"+rno+"']").length > 0){
    document.querySelector("[data-id='"+rno+"'] .updateno").remove();
    var td = document.createElement("td");
    td.innerHTML = response.data;
    document.querySelector("[data-id='"+rno+"']").appendChild(td);
  }else{
    document.querySelector("[data-id='"+rno+"'] .updateno").remove();
    var td = document.createElement("td");
    td.innerHTML = "not found";
    document.querySelector("[data-id='"+rno+"']").appendChild(td);
  }
  })
  .catch(error => console.log('error', error));

}

const generateTable = function(responseData){
  myplaceids.querySelector("tbody").innerHTML = responseData;
}

getplaceids.addEventListener("click",function(e){
  var txt = encodeURIComponent(placeidtext.value);
var requestOptions = {
  method: 'POST',
  redirect: 'follow',
  body: JSON.stringify({'query':txt,'key':'getlist'})
};

fetch('operations.php', requestOptions)
  .then((response) => response.json())
  .then((data) => {
    if(data.status){
      generateTable(data.data);
    }
  })
  .catch(error => console.log('error', error));
 });
</script>
</body>
</html>