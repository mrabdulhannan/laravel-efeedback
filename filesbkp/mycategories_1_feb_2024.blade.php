@extends('layouts.app')

@push('stylesheet-page-level')
    <style>
        .list-group-item.selected2 {
            background-color: #007bff;
            color: white;
        }

        .accordion-button {
            padding-left: 50px !important;
        }

        .accordion-button:after {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-plus' viewBox='0 0 16 16'%3E%3Cpath d='M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z'/%3E%3C/svg%3E") !important;
            transition: all 0.5s !important;
            position: absolute !important;
            background-size: 2.00rem !important;
            background-position: -9px -7px !important;
            left: 18px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            content: '' !important;
        }

        .accordion-button:not(.collapsed):after {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='rgba(255,255,255)' class='bi bi-dash' viewBox='0 0 16 16'%3E%3Cpath d='M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z'/%3E%3C/svg%3E") !important;
            position: absolute !important;
            left: 18px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            content: '' !important;
        }
    </style>
     <style>
        .accordion-item {
            position: relative;
            padding: 0 0 0 25px;
        }
        .accordion-item::before {
            position: absolute;
            left: 7px;
            top: 16px;
            bottom: 16px;
            width: 2px;
            content: '';
            border: 4px dotted gray;
            width: 10px;
            z-index: 99;
            height: 22px;
            cursor: move;
        }
    </style>
@endpush
@section('content')
    <!-- Row start -->
    <div class="row">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">My Categories</h2>
                </div>


                <div class="card-body">
                    <div class="">
                        <div class="custom-tabs-container">
                            @if (Auth::user()->definetopic !== null && count(Auth::user()->definetopic) > 0)
                                <ul class="nav nav-tabs" id="customTabs" role="tablist">
                                    @foreach (Auth::user()->definetopic as $key => $topic)
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link {{ $key === 0 ? 'active' : '' }}" data-bs-toggle="tab"
                                                href="#tab-{{ $topic->id }}" role="tab"
                                                aria-controls="tab-{{ $topic->id }}"
                                                aria-selected="{{ $key === 0 ? 'true' : 'false' }}">{{ $topic->title }}
                                                @php
                                                    // Count the categories for the current topic
                                                    $categoryCount = Auth::user()
                                                        ->definecategories->where('topic_id', $topic->id)
                                                        ->count();
                                                @endphp
                                                @if ($categoryCount > 0)
                                                    <span class="badge bg-info">{{ $categoryCount }}</span>
                                                @endif
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="tab-content" id="customTabContent">
                                    @foreach (Auth::user()->definetopic as $key => $topic)
                                        <div class="tab-pane fade {{ $key === 0 ? 'active show' : '' }}"
                                            id="tab-{{ $topic->id }}" role="tabpanel"
                                            aria-labelledby="tab-{{ $topic->id }}">


                                            @php
                                                // Group categories by their 'group' attribute
                                                // $groupedCategories = Auth::user()
                                                //     ->definecategories->where('topic_id', $topic->id)
                                                //     ->groupBy('group')->orderBy('group_order');
                                                $groupedCategories = DB::table('define_categories')
                                                    ->select('group', DB::raw('MAX(id) as id'), DB::raw('MAX(group_order) as group_order'))
                                                    ->where('topic_id', $topic->id)
                                                    ->groupBy('group')
                                                    ->orderBy('group_order') // Change this line
                                                    ->get();
                                                $allGroups = [];

                                                // Iterate through the groupedCategories collection
                                                foreach ($groupedCategories as $groupedCategory) {
                                                    // Extract group and group_order
                                                    $group = $groupedCategory->group;
                                                    $groupOrder = $groupedCategory->group_order;

                                                    // Store the group and order in the array
                                                    $allGroups[] = [
                                                        'group' => $group,
                                                        'group_order' => $groupOrder,
                                                    ];
                                                }

                                            @endphp
                                            <div style="text-align:right">
                                                <form action="{{ route('definecategories', ['id' => $topic->id]) }}"
                                                    method="get" class="">
                                                    @csrf
                                                    <div>
                                                        <button type="submit" class="btn btn-secondary  btn-sm">Add
                                                            Category</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <ul class="list-group" id="itemsListAccordian-{{ $topic->id }}">
                                                @foreach ($allGroups as $groupData)
                                                    @php
                                                        $group = $groupData['group'];
                                                        $group_order = $groupData['group_order'];
                                                        $cleanGroup = strtolower(preg_replace('/[^a-zA-Z0-9]/', '_', $group));

                                                        $categories = Auth::user()
                                                            ->definecategories->where('group', $group)
                                                            ->sortByDesc('group_order')
                                                            ->all();

                                                    @endphp

                                                    <li data-groupvalue="{{ $group }}"
                                                        data-grouporder="{{ $group_order }}">
                                                        <div class="accordion mt-1"
                                                            id="accordion_{{ $topic->id }}_{{ $cleanGroup }}">
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header"
                                                                    id="heading_{{ $topic->id }}_{{ str_replace(' ', '_', $group) }}">
                                                                    <button class="accordion-button collapsed"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#collapse_{{ $topic->id }}_{{ str_replace(' ', '_', $group) }}"
                                                                        aria-expanded="true"
                                                                        aria-controls="collapse_{{ $topic->id }}_{{ str_replace(' ', '_', $group) }}">
                                                                        {{ $group }}
                                                                    </button>
                                                                </h2>
                                                                <div id="collapse_{{ $topic->id }}_{{ str_replace(' ', '_', $group) }}"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="heading_{{ $topic->id }}_{{ str_replace(' ', '_', $group) }}"
                                                                    data-bs-parent="#accordion_{{ $topic->id }}_{{ str_replace(' ', '_', $group) }}">
                                                                    <div class="accordion-body">
                                                                        <ul class="list-group" id="itemsList">
                                                                            @foreach ($categories as $category)
                                                                                <li
                                                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                                                    <div>
                                                                                        <h5 class="mb-1">
                                                                                            {{ $category->title }}
                                                                                        </h5>
                                                                                        <p class="mb-1">
                                                                                            {{ $category->description }}
                                                                                        </p>
                                                                                        {{-- <span class="badge bg-info">{{ $category->group }}</span> --}}
                                                                                    </div>
                                                                                    <div class="d-flex">
                                                                                        <div>
                                                                                            <form
                                                                                                action="{{ route('editCategory', ['id' => $category->id]) }}"
                                                                                                method="post">
                                                                                                @csrf
                                                                                                <button type="submit"
                                                                                                    class="btn btn-warning  btn-sm me-1">Edit</button>
                                                                                            </form>
                                                                                        </div>
                                                                                        <div>
                                                                                            <form
                                                                                                action="{{ route('deleteCategory', ['id' => $category->id]) }}"
                                                                                                method="post"
                                                                                                onsubmit="return confirm('Are you sure you want to delete this category?')">
                                                                                                @csrf
                                                                                                @method('DELETE')
                                                                                                <button type="submit"
                                                                                                    class="btn btn-danger btn-sm">Delete</button>
                                                                                            </form>
                                                                                        </div>
                                                                                    </div>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>





                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p>No topics available.</p>
                            @endif
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-page-level')
    <script>
        $(document).ready(function() {
            $('#customTabs a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                // Handle tab shown event if needed
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Add 'active' class to the first tab on page load
            $('#customTabs li:first-child a').addClass('active tab-active');

            // ... Your existing JavaScript code ...
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {
            // Make the list items sortable
            // $("#itemsList").sortable({
            //     update: function(event, ui) {
            //         //  updateOrder();
            //         console.log("Cahnge Ocuur")

            //     }
            // });   

            $('[id^="itemsListAccordian"]').sortable({
                update: function(event, ui) {
                    console.log("Change Occurred");
                    // Extract the group value and order from the dragged item
                    var groupValue = $(ui.item).data('groupvalue');
                    var groupOrder = $(ui.item).data('grouporder');

                    // Extract the order of categories within the group
                    var categoryOrder = $(this).sortable('toArray', {
                        attribute: 'data-category-id'
                    });

                    // Extract all group values and orders
                    var groupData = [];


                    $('[data-groupvalue]').each(function() {

                        let group = $(this).data('groupvalue');
                        let order = $(this).data('grouporder');

                        if (order === null || order === undefined || order === 'null' ||
                            order === "") {
                            console.log("Order is Null");
                            order = 1; // Set a default group order of 1
                        }

                        groupData.push({
                            group: group,
                            order: order
                        });
                    });

                    // AJAX call to update the order
                    // $.ajax({
                    //     type: 'POST',
                    //     url: '{{ route('updateGroupOrder') }}',
                    //     data: {
                    // group_id: groupID,
                    // category_order: categoryOrder
                    //         _token: '{{ csrf_token() }}'
                    //     },
                    //     success: function(response) {
                    //         console.log(response);
                    //         // Handle success response if needed
                    //         console.log('Order updated successfully');
                    //     },
                    //     error: function(error) {
                    //         // Handle error if needed
                    //         console.error('Error updating order:', error);
                    //     }
                    // });
                    $.ajax({
                        type: "POST",
                        url: "{{ route('updateGroupOrder') }}",
                        data: {
                            group_id: groupValue,
                            group_order: groupOrder,
                            all_groups: groupData,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }
            });
        });
    </script>
@endpush
