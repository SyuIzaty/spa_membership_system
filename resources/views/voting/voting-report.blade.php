@extends('layouts.admin')

@section('content')
<main id="js-page-content" role="main" class="page-content">
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        VOTING <span class="fw-300"><i>REPORT</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 mt-3">
                                <form action="{{ route('voting-report') }}" method="GET" id="form_find">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-3">
                                            <select name="vote" id="vote" class="form-control">
                                                <option value="" disabled selected> Please select</option>
                                                @foreach ($vote as $votes)
                                                    <option value="{{ $votes->id }}" {{ $selectedVote == $votes->id ? 'selected' : '' }}>{{ strtoupper($votes->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </form>
                                <div id="spinner" style="display: none;">
                                    <i class="fas fa-spinner fa-spin"></i> Loading...
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div id="report-section">
                                    <!-- The report section content will be loaded dynamically here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')

<script>
    $(document).ready(function() {
        $('#vote').select2();

        // Add an event listener for the select change
        $('#vote').on('change', function() {
            var selectedVote = $(this).val();

            // Display the spinner
            $('#spinner').show();

            // Send an Ajax request to the controller
            $.ajax({
                url: '{{ route('voting-report') }}',
                type: 'GET',
                data: { vote: selectedVote },
                success: function(data) {
                    // Hide the spinner
                    $('#spinner').hide();

                    // Replace the report section with the returned data
                    $('#report-section').html(data);
                },
                error: function() {
                    // Handle errors if needed
                    $('#spinner').hide();
                    alert('An error occurred.');
                }
            });
        });
    });
</script>
<script>
    function openPrintWindow(event) {
        event.preventDefault(); // Prevent the link from navigating immediately

        var url = event.target.href; // Get the URL from the link
        var newTab = window.open(url, '_blank'); // Open a new tab with the URL

        // Wait for the new tab to load, then trigger the print dialog
        newTab.onload = function () {
            newTab.print();
        };
    }
</script>

@endsection
