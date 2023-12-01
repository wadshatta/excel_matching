<!DOCTYPE html>
<html>
<head>
    <title>Laravel 8 Autocomplete Search from Database - Techsolutionstuff</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
</head>
<body>   
<div class="container">
    <h2 style="margin: 30px 0px; text-align: center;">Laravel 8 Autocomplete Search from Database - Techsolutionstuff</h2>   
    <input class="search form-control" type="text" name="name" placeholder="Search here...">
</div>   
<script type="text/javascript">
    var path = "{{ route('autocomplete') }}";
    $('input.search').typeahead({
        source:  function (str, process) 
        {
          return $.get(path, { str: str }, function (data) {
                return process(data);
            });
        }
    });
</script>   
</body>
</html>