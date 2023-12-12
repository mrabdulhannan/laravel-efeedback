@extends('layouts.app')

@section('content')
                <!-- Content wrapper scroll start -->
                <div class="content-wrapper-scroll">

                    <!-- Content wrapper start -->
                    <div class="content-wrapper">
    
                        <!-- Row start -->
                        <div class="row">
                            <div class="col-xxl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h2 class="card-title">Define Categories</h2>
    
                                        <form action="" method="post">
    
                                            <!-- Title Input -->
                                            <div class="mb-3">
                                                <label for="title" class="form-label">Title</label>
                                                <input type="text" class="form-control" id="title" name="title" required>
                                            </div>
    
                                            <!-- Description Textarea -->
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                                            </div>
    
                                            <!-- Type Dropdown -->
                                            <div class="mb-3">
                                                <label for="group" class="form-label">Group</label>
                                                <div class="input-group">
                                                    <select class="form-select" id="group" name="type" required>
                                                        <option value="option1">Table and Content</option>
                                                        <option value="option2">Referencing &amp; Citation</option>
                                                        <option value="option3">Option 3</option>
                                                    </select>
                                                </div>
                                            </div>
    
                                            <!-- Save Button -->
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Row end -->
    
                    </div>
                    <!-- Content wrapper end -->
    
    
                </div>
                <!-- Content wrapper scroll end -->
@endsection
