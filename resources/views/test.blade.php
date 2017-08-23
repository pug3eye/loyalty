<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>TEST</title>
  </head>
  <body>
    <form action="{{ url('redeem') }}" method="post">
      <input type="text" name="code">
      <input type="submit" value="Submit">
    </form>
  </body>
</html>
