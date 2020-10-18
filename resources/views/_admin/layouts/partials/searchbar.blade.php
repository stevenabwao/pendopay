<?php

    $companies = "";
    $categories = "";

    if (array_key_exists('companies', $data)) {
        $companies = $data['companies'];
    }

    if (array_key_exists('categories', $data)) {
        $categories = $data['categories'];
    }
    // dd($data);
?>

<div>

    <form action="@yield('post_page')">
        <table class="table table-search">
            <tr>

            <td>

                <div class="pull-left col-sm-12 col-sm-6 col-md-2">

                    {{-- if data to be downloaded exists, show download option --}}
                    @if (count($data['parent']))
                        <div class="btn-group">
                            <div class="dropdown">
                                <button
                                aria-expanded="false"
                                data-toggle="dropdown"
                                class="btn btn-success dropdown-toggle "
                                type="button">
                                Download
                                <span class="caret ml-10"></span>
                                </button>
                                <ul role="menu" class="dropdown-menu">

                                    <li><a href="@yield('excel_xls_url')">As Excel</a></li>
                                    <li><a href="@yield('excel_csv_url')">As CSV</a></li>
                                    <li><a href="@yield('excel_pdf_url')">As PDF</a></li>

                                </ul>
                            </div>
                        </div>
                    @endif

                    {{-- if create item link exists, show create button --}}
                    @if (array_key_exists('show_create_link', $data))
                        <a href="@yield('create_page')"
                            class="btn btn-info btn-sm btn-icon-anim btn-square"
                            title="@yield('create_page_link_title')">
                            <i class="zmdi zmdi-plus"></i>
                        </a>
                    @endif

                </div>

                <div class="col-sm-12 col-sm-6 col-md-2">

                    <input type="hidden" value="1" name="search">

                    <input
                        type='text'
                        class="form-control"
                        placeholder="Enter Search Term"
                        id='account_search'
                        name="account_search"

                        @if (app('request')->input('account_search'))
                            value="{{ app('request')->input('account_search') }}"
                        @endif

                    />

                </div>

                <div class="col-sm-12 col-sm-6 col-md-2">

                    <div class='input-group date' id='start_date_group'>
                        <input
                            type='text'
                            class="form-control"
                            placeholder="Start Date"
                            id='start_date'
                            name="start_date"

                            @if (app('request')->input('start_date'))
                                value="{{ app('request')->input('start_date') }}"
                            @endif

                        />
                        <span class="input-group-addon">
                            <span class="fa fa-calendar"></span>
                        </span>
                    </div>

                </div>

                <div class="col-sm-12 col-sm-6 col-md-2">

                    <div class='input-group date' id='end_date_group'>
                        <input
                            type='text'
                            class="form-control"
                            placeholder="End Date"
                            id='end_date'
                            name="end_date"

                            @if (app('request')->input('end_date'))
                                value="{{ app('request')->input('end_date') }}"
                            @endif

                        />
                        <span class="input-group-addon">
                            <span class="fa fa-calendar"></span>
                        </span>
                    </div>

                </div>

                <div class="col-sm-12 col-sm-6 col-md-1">
                    <a class="btn btn-default btn-icon-anim btn-circle"
                    data-toggle="tooltip" data-placement="top"
                    title="Clear dates" id="clear_date">
                    <i class="zmdi zmdi-chart-donut"></i>
                    </a>
                </div>

                <?php
                    if (array_key_exists('statuses', $data)) {
                ?>

                    <div class="col-sm-12 col-sm-6 col-md-1">

                        <select class="selectpicker form-control" name="status_id"
                            data-style="form-control btn-default btn-outline">

                            <li class="mb-10">
                                    <option value=""
                                    @if (!(app('request')->input('status_id')))
                                        selected="selected"
                                    @endif
                                    >Status
                                    </option>
                            </li>

                            @foreach ($statuses as $status)

                                <li class="mb-10">
                                    <option value="{{ $status->id }}"
                                    @if ($status->id == app('request')->input('status_id'))
                                        selected="selected"
                                    @endif
                                    >
                                    {{ $status->name }}
                                    </option>
                                </li>

                            @endforeach

                        </select>

                    </div>

                <?php
                    }
                ?>

                @if (isSuperAdmin())
                    @if ($companies)
                        <div class="col-sm-12 col-sm-6 col-md-1">

                            <select class="selectpicker form-control" name="companies"
                            data-style="form-control btn-default btn-outline">

                                    <li class="mb-10">
                                    <option value=""
                                    @if (!(app('request')->input('companies')) ||
                                                checkCharExists(',', (app('request')->input('companies')))
                                        )
                                        selected="selected"
                                    @endif
                                    >Select company
                                    </option>
                                    </li>

                                    @foreach ($companies as $company)

                                    <li class="mb-10">

                                    <option value="{{ $company->id }}"

                                        @if (($company->id == app('request')->input('companies')) &&
                                                !(checkCharExists(',', (app('request')->input('companies'))))
                                                )
                                                selected="selected"
                                        @endif

                                    >

                                    {{ $company->name }}

                                    </option>

                                    </li>

                                    @endforeach

                            </select>

                        </div>
                    @endif
                @endif

                @if ($categories)
                        <div class="col-sm-12 col-sm-6 col-md-2">

                            <select class="selectpicker form-control" name="categories"
                            data-style="form-control btn-default btn-outline">

                                    <li class="mb-10">
                                    <option value=""
                                    @if (!(app('request')->input('categories')) ||
                                                checkCharExists(',', (app('request')->input('categories')))
                                        )
                                        selected="selected"
                                    @endif
                                    >Select category
                                    </option>
                                    </li>

                                    @foreach ($categories as $category)

                                    <li class="mb-10">

                                    <option value="{{ $category->id }}"

                                        @if (($category->id == app('request')->input('categories')) &&
                                                !(checkCharExists(',', (app('request')->input('categories'))))
                                                )
                                                selected="selected"
                                        @endif

                                    >

                                    {{ $category->name }}

                                    </option>

                                    </li>

                                    @endforeach

                            </select>

                        </div>
                    @endif

                <div class="col-sm-12 col-sm-6 col-md-1">
                    <select class="selectpicker form-control" name="limit"
                    data-style="form-control btn-default btn-outline">

                        <li class="mb-10">

                        <option value="20"
                            @if (app('request')->input('limit') == 20)
                                selected="selected"
                            @endif
                            >
                            20
                        </option>

                        </li>

                        <li class="mb-10">

                        <option value="50"
                            @if (app('request')->input('limit') == 50)
                                selected="selected"
                            @endif
                            >
                            50
                        </option>

                        </li>

                        <li class="mb-10">

                        <option value="100"
                            @if (app('request')->input('limit') == 100)
                                selected="selected"
                            @endif
                            >
                            100
                        </option>

                        </li>

                    </select>
                </div>

                <div class="col-sm-12 col-sm-12 col-md-1">
                <button class="btn btn-primary btn-block text-center">Filter</button>
                </div>

            </td>

            </tr>
        </table>
    </form>

</div>
<div class="clearfix"></div>
