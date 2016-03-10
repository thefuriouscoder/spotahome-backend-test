var st;
$(document).ready(function() {
    var template = $.trim($("#template").html());
    Mustache.parse(template);
    var view = function(record, index){
        return Mustache.render(template, {record: record, index: index});
    };
    var $summary = $('#summary');
    var $found = $('#found');

    $('#found').hide();

    var callbacks = {
        after_add: function(data){
            //Do what ever you want.
        },
        pagination: function(summary){
            if ($.trim($('#st_search').val()).length > 0){
                $found.text('Found : '+ summary.total).show();
            }else{
                $found.hide();
            }
            $summary.text( summary.from + ' to '+ summary.to +' of '+ summary.total +' entries');
        }
    }

    st = StreamTable('#stream_table',
        { view: view,
            data_url: '/api/properties',
            fetch_data_limit: 200,
            per_page: 10,
            callbacks: callbacks,
            pagination: {span: 5, next_text: 'Next &rarr;', prev_text: '&larr; Previous'}
        },[]
    );

    /*
     NOTE: Search only for year. If you define fields function then it must return text.
     You have complex nested record data then use function.
     st = StreamTable('#stream_table',
     { view: view,
     per_page: 10,
     callbacks: callbacks,
     pagination: {span: 5, next_text: 'Next &rarr;', prev_text: '&larr; Previous'},
     fields: function(r){ return [ r.year, r.rating].join(' ')} // OR fields: ['year' , 'rating']
     },
     data
     );
     */

    // Jquery plugin
    //$('#stream_table').stream_table({view: view}, data)

    // $('.record_count .badge').text(data.length);

});

function randomMovies(){
    var i = Math.floor(parseInt(Math.random()*100)) % Movies.length;
    return Movies[i];
}

function addMovies(count){
    if (count){
        for(var i = 0; i < count; i++)
            st.addData(randomMovies());
    }else{
        st.addData(randomMovies());
    }

    $('.record_count .badge').text(st.data.length);
    $('#spinner').hide();
}
