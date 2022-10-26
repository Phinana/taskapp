
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