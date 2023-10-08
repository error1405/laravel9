<x-header />
<div class="container-fluid py-4" style="min-height: 700px;">

    <h1>Search Book</h1>

    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col col-md-6">
                    <i class="fas fa-table me-1"></i> Book List
                </div>
                <div class="col col-md-6" align="right">

                </div>
            </div>
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr style="height:39.88px;">
                        <th>Book Name</th>
                        <th>ISBN No.</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Location Rack</th>
                        <th>No. of Available Copy</th>
                        <th>Status</th>
                        <th>Added On</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr style="height:39.88px;">
                        <th>Book Name</th>
                        <th>ISBN No.</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Location Rack</th>
                        <th>No. of Available Copy</th>
                        <th>Status</th>
                        <th>Added On</th>
                    </tr>
                </tfoot>
                <tbody>


                    @if(count($result_show) > 0)
                        @foreach($result_show as $row)
                            @php
                                $book_status = '';
                                if ($row['book_no_of_copy'] > 0) {
                                $book_status = '<div class="badge bg-success">Available</div>';
                                } else {
                                $book_status = '<div class="badge bg-danger">Not Available</div>';
                                }
                            @endphp

                            <tr style="height:39.88px;">
                                <td>{{ $row["book_name"] }}</td>
                                <td>{{ $row["book_isbn_number"] }}</td>
                                <td>{{ $row["book_category"] }}</td>
                                <td>{{ $row["book_author"] }}</td>
                                <td>{{ $row["book_location_rack"] }}</td>
                                <td>{{ $row["book_no_of_copy"] }}</td>
                                <td>{!! $book_status !!}</td>
                                <td>{{ $row["book_added_on"] }}</td>
                            </tr>

                        @endforeach
                    @else

                        <tr>
                            <td colspan="8" class="text-center">No Data Found</td>
                        </tr>

                    @endif


                </tbody>
            </table>
        </div>
    </div>
</div>
<x-footer />
