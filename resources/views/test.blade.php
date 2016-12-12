<!doctype html>
<html>
<head>
<meta charset="utf8" />
<style>
#crawl-form {
  margin-top:20px;
}
.form-field {
  margin-bottom:20px;
}
label {
  display: inline-block;
  width:80px;
  text-align: right;
}
input[type=text] {
  width:300px;
}
input:focus {
  outline: none;
}
.form-action {
  text-align: left;
  margin-left:80px;
}
</style>
</head>
<body>
<div id="crawl-form">
  <div class="form-field">
    <label>url：</label>
    <input type="text" />
  </div>
  <div class="form-field">
    <label>news：</label>
    <input type="text" />
  </div>
  <div class="form-field">
    <label>title：</label>
    <input type="text" />
  </div>
  <div class="form-field">
    <label>digest：</label>
    <input type="text" />
  </div>
  <div class="form-action">
    <input type="button" value="提交" />
  </div>
</div>
</body>
</html>
