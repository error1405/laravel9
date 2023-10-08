<x-header />
<div class="container-fluid py-4" style="min-height: 700px;">
    <h1>Issue Book Detail</h1>
    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col col-md-6">
                    <i class="fas fa-table me-1"></i> Issue Book Detail
                </div>
                <div class="col col-md-6" align="right">
                </div>
            </div>
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Book ISBN No.</th>
                        <th>Book Name</th>
                        <th>Issue Date</th>
                        <th>Return Date</th>
                        <th>Fines</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Book ISBN No.</th>
                        <th>Book Name</th>
                        <th>Issue Date</th>
                        <th>Return Date</th>
                        <th>Fines</th>
                        <th>Status</th>
                    </tr>
                </tfoot>
                <tbody>
                    @if(count($result_show) > 0)
                        @foreach($result_show as $row)
                            @php
                                $status = $row["book_issue_status"];
                                if ($status == 'Issue') {
                                $status = '<span class="badge bg-warning">Issue</span>';
                                }

                                if ($status == 'Not Return') {
                                $status = '<span class="badge bg-danger">Not Return</span>';
                                }

                                if ($status == 'Return') {
                                $status = '<span class="badge bg-primary">Return</span>';
                                }
                            @endphp

                            <tr>
                                <td>{{ $row["book_isbn_number"] }}</td>
                                <td>{{ $row["book_name"] }}</td>
                                <td>{{ $row["issue_date_time"] }}</td>
                                <td>{{ $row["return_date_time"] }}</td>
                                <td>
                                    <span style="font-family: DejaVu Sans;">&#8377;</span>
                                    {{ $row["book_fines"] }}
                                </td>
                                <td>{!! $status !!}</td>
                            </tr>

                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>
<x-footer />
