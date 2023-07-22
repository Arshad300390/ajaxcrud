<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<a class="btn btn-success" href="{{ url('/') }}">Back</a>
<h1>Student Data</h1>
<table border="1" id="students-table">
    <tr>
        <th>S.No</th>
        <th>Name</th>
        <th>Email</th>
        <th>Image</th>
        <th>Action</th>
    </tr>
</table>

<script>
    $(document).ready(function() {
        $.ajax({
            type: "get",
            url: "{{ route('getStudents') }}",
            success: function(data) {

                if (data.students.length > 0) {
                    for (let i = 0; i < data.students.length; i++) {
                        let img = data.students[i]['file'];
                        $("#students-table").append(`<tr>
                        <td>` + (i + 1) + `</td>
                        <td>` + (data.students[i]['name']) + `</td>
                        <td>` + (data.students[i]['email']) + `</td>
                        <td><img  src ="{{ asset('storage/`+img+`') }}" alt='` + img + `'
                             width='` + 120 + `' height='` + 80 + `'/></td>
                            //  <td><a href="{{ route('delStudent') }}"/></td>
                        </tr>`);
                        console.log(img);
                    }
                } else {
                    $("#students-table").append("<tr> <td colspan='4'>Data not found</td></tr>");
                }
            }
        });
    });
</script>
