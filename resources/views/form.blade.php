<!DOCTYPE html>
<html lang="en">

<head>
    <title>create student</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <style>
        /* Basic styling for buttons */
        .btn {
            display: inline-block;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
        }

        /* Styling for the "Back" button */
        .btn-success {
            background-color: #007bff;
            color: #fff;
            width: 73.5%;
            margin: 10px 150px;
        }

        /* Styling for the form and its inputs */
        #my-form {
            margin-bottom: 20px;
            margin-left: 150px;
        }

        input[type="text"],
        input[type="email"],
        input[type="file"],
        input[type="submit"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 80%;
        }

        /* Styling for the "Add Student" button */
        #btnSubmit {
            background-color: #007bff;
            color: #fff;
        }

        /* Styling for the table */
        #students-table {
            margin: 30px;
            width: 90%;
            border-collapse: collapse;
        }

        #students-table th,
        #students-table td {
            padding: 8px;
            border: 1px solid #ccc;
        }

        #students-table th {
            background-color: #f2f2f2;
        }

        /* Styling for the header */
        h1 {
            margin-bottom: 10px;
        }

        /* Styling for the output span */
        #output {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <a class="btn btn-success" href="{{ url('/') }}">Back</a>

    <form id="my-form">
        @csrf
        <input type="text" name="name" placeholder="Enter name" required>
        <br><br>
        <input type="email" name="email" placeholder="Enter email" required>
        <br><br>
        <input type="file" name="file" required>
        <br><br>
        <input type="submit" value="Add Student" id="btnSubmit">
    </form>
    <span id="output"> </span>
    <div>
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

    </div>
    <script>
        $(document).ready(function() {
            $("#my-form").submit(function(event) {
                event.preventDefault();
                var form = $("#my-form")[0];
                var data = new FormData(form);
                $("#btnSubmit").prop('disabled', true);

                $.ajax({
                    type: "post",
                    url: "{{ route('addStudent') }}",
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        $("#output").text(data.res);
                        $("#btnSubmit").prop('disabled', false);
                        $("input[type='text']").val('');
                        $("input[type='email']").val('');
                        $("input[type='file']").val('');
                        removeRow();
                        studentData();
                    },
                    error: function(e) {
                        $("#output").text(e.responsetext);
                        $("#btnSubmit").prop('disabled', false);
                        $("input[type='text']").val('');
                        $("input[type='email']").val('');
                        $("input[type='file']").val('');
                        removeRow();
                        studentData();
                    }
                })
            });

            studentData();






            function studentData() {
                $.ajax({
                    type: "get",
                    url: "{{ route('getStudents') }}",
                    success: function(data) {

                        if (data.students.length > 0) {
                            for (let i = 0; i < data.students.length; i++) {
                                let img = data.students[i]['file'];
                                let id = data.students[i]['id'];
                                console.log(id);
                                $("#students-table").append(`<tr class='appendTr'>
                                        <td>` + (i + 1) + `</td>
                                        <td>` + (data.students[i]['name']) + `</td>
                                        <td>` + (data.students[i]['email']) + `</td>
                                        <td><img  src ="{{ asset('storage/`+img+`') }}" alt='` + img + `' width='` +
                                    120 + `' height='` + 80 + `'/></td>
                                        <td> <button id="` + id + `">click</button></td>
                                        </tr>`);
                            }
                        } else {
                            $("#students-table").append(
                                "<tr> <td colspan='4'>Data not found</td></tr>");
                        }
                    }
                });
            }

            function removeRow() {
                $(".appendTr").remove();
            }
            var recordTable = document.getElementById("students-table");

            Add a click event listener to the container
            recordTable.addEventListener('click', function(event) {
                if (event.target.nodeName === 'BUTTON') {
                    let id = event.target.getAttribute('id');
                    $.ajax({
                        type: "get",
                        url: "{{ route('delStudent') }}",
                        //data:id,
                        success: function(data) {
                            console.log(data)
                        }
                    });
                    console.log('Button clicked:', event.target.getAttribute('id'));
                }
            });
        });
    </script>
</body>

</html>
