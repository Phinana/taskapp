<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <title></title>
</head>
<body>
    @foreach($tasks as $task)
    <div class="card w-100 post text-center {{ $task->id }}element">
            <div class="card-body">
                <h5 class="card-title">{{ $task->title }}</h5>
                <p class="card-text">{{ $task->difficulty }}</p>
                <p class="card-text">{{ $task->reward }}</p>
                <button value="{{ $task->id }}" type="button" id="delete" data-bs-toggle="modal" data-bs-target="#deletemodal" class="btn btn-primary pull-right delete_button">Delete</button>
                <button value="{{ $task->id }}" type="button" id="edit" data-bs-toggle="modal" data-bs-target="#addnew" class="btn btn-primary pull-right edit_button">Edit</button>
            </div>
        </div>
    @endforeach

    <div class="text-center"><a href="{{ route('home_index') }}" class="button text-center">Go back</a></div>
</body>
</html>

@include('modals.delete')
@include('modals.edit')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    
    var currentId = 0;
        checkWindowSize();
        
        // sayfada ne kadar veri var ona gore bakip veri çekiyoruz
        function checkWindowSize(){
            if($(window).height() > $(document).height() || $(window).height() == $(document).height()){
                fetchData();
            }
        }

        //verilerin yanında bulunan silme tuşu, tıklayınca mevcut id'yi alır
        $(document).on("click", "#delete", function () {
            currentId = $(this).attr("value");
        });

        //pop üzerinde bulunan silme tuşu
        $(document).on("click", "#deletemember", function () {
            $.ajax({
                type: "POST",
                data:{
                    'taskId': currentId,
                    '_token': '{{ csrf_token() }}',
                },
                url: "{{ route('home_destroy') }}",
                success: function (response) {
                    $('.'+currentId+'element').remove();
                }
            });
            $("#deletemodal").modal("hide");
        });
    
        //Verilerin yanındaki edit tuşu
        $(document).on("click", "#edit", function () {
            currentId = $(this).attr("value");
        });

        //Popup üzerinde bulunan edit tuşu
        $(document).on("click", "#edittask", function () {
            var title = $("#title").val();
            var difficulty = $("#difficulty").val();
            var reward = $("#reward").val();
            $.ajax({
                type: "POST",
                data:{
                    'title': title,
                    'difficulty': difficulty,
                    'reward': reward,
                    'id': currentId,
                    '_token': '{{ csrf_token() }}',
                },
                url: "{{ route('home_update') }}",
                success: function (response) {
                }
            });
            $("#addnew").modal("hide");
        });

        // kaldığı yerden veriyi alıyoruz,
        function fetchData(){
            var start = Number($('#start').val());
            var allcount = Number($('#totalrecords').val());
            var rowperpage = Number($('#rowperpage').val());
            start = start + rowperpage;
    
            if(start <= allcount){
                $('#start').val(start);
    
                $.ajax({
                    type: "POST",
                    url:"{{route('home_getTasks')}}",
                    data: {start:start, '_token': '{{ csrf_token() }}'},
                    dataType: 'json',
                        success: function(response){
                        // ekleme işlemi
                        $(".post:last").after(response.html).show().fadeIn("slow");
    
                        //Veriler ekrandan taşıp taşmadığına bakıyoruz, eğer ekran dolmamışsa kendini tekrar çağırır
                        checkWindowSize();
                    }
                });
            }
        }
        
        function onScroll(){
             if($(window).scrollTop() > $(document).height() - $(window).height()-100) {
                   fetchData(); 
             }
        }

        //bu değişkenler burada kullanıldığından en üste değil buraya koydum, erkanı kontrol eden fonksiyon kullanıyor
        var _throttleTimer = null;
        var _throttleDelay = 100;
        var $window = $(window);    
        var $document = $(document);

        $document.ready(function () {
            $window
                .off('scroll', ScrollHandler)
                .on('scroll', ScrollHandler);

        });

        function ScrollHandler(e) {
            //eğer ekran büyükse veri alma fonksiyonunu çağırır, fare tekerleği döndüğünde çalışır
            clearTimeout(_throttleTimer);
            _throttleTimer = setTimeout(function () {
            console.log('scroll');
            //ekranın üstte kalan kısmı + mevcut pencere boyutu dokümandan büyükse çalışır.
            if ($window.scrollTop() + $window.height() >= $document.height()) {
                fetchData();
            }
                }, _throttleDelay);
        }
</script>