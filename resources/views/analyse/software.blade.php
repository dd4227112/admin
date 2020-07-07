@extends('layouts.app')
@section('content')
<?php $root = url('/') . '/public/' ?><div class="main-body">
        <div class="page-wrapper">
            <div class="page-header">
                <div class="page-header-title">
                    <h4>Project Dashboard</h4>
                </div>
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="index-2.html">
                                <i class="icofont icofont-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Project</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="page-body">
                <div class="row">
                    <!-- Documents card start -->
                    <div class="col-md-6 col-xl-3">
                        <div class="card client-blocks dark-primary-border">
                            <div class="card-block">
                                <h5>New Documents</h5>
                                <ul>
                                    <li>
                                        <i class="icofont icofont-document-folder"></i>
                                    </li>
                                    <li class="text-right">
                                        133
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Documents card end -->
                    <!-- New clients card start -->
                    <div class="col-md-6 col-xl-3">
                        <div class="card client-blocks warning-border">
                            <div class="card-block">
                                <h5>New Clients</h5>
                                <ul>
                                    <li>
                                        <i class="icofont icofont-ui-user-group text-warning"></i>
                                    </li>
                                    <li class="text-right text-warning">
                                        23
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- New clients card end -->
                    <!-- New files card start -->
                    <div class="col-md-6 col-xl-3">
                        <div class="card client-blocks success-border">
                            <div class="card-block">
                                <h5>New Files</h5>
                                <ul>
                                    <li>
                                        <i class="icofont icofont-files text-success"></i>
                                    </li>
                                    <li class="text-right text-success">
                                        240
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- New files card end -->
                    <!-- Open Project card start -->
                    <div class="col-md-6 col-xl-3">
                        <div class="card client-blocks">
                            <div class="card-block">
                                <h5>Open Projects</h5>
                                <ul>
                                    <li>
                                        <i class="icofont icofont-ui-folder text-primary"></i>
                                    </li>
                                    <li class="text-right text-primary">
                                        169
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Open Project card end -->
                    <!-- Morris chart start -->
                    <div class="col-md-12 col-xl-8">
                        <div class="card">
                            <div class="card-header">
                                <button class="btn btn-primary btn-sm">Week</button>
                                <button class="btn btn-primary btn-sm">Month</button>
                                <button class="btn btn-primary btn-sm">Year</button>
                            </div>
                            <div class="card-block">
                                <div id="morris-extra-area" style="height: 470px; position: relative;"><svg height="400" version="1.1" width="650.938" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="overflow: hidden; position: relative; left: -0.796875px; top: -0.796875px;"><desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.2.0</desc><defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs><text x="32.859375" y="361" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">0</tspan></text><path fill="none" stroke="#5fbeaa" d="M45.359375,361H625.938" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="32.859375" y="277" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">50</tspan></text><path fill="none" stroke="#5fbeaa" d="M45.359375,277H625.938" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="32.859375" y="193" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">100</tspan></text><path fill="none" stroke="#5fbeaa" d="M45.359375,193H625.938" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="32.859375" y="109" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">150</tspan></text><path fill="none" stroke="#5fbeaa" d="M45.359375,109H625.938" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="32.859375" y="25" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">200</tspan></text><path fill="none" stroke="#5fbeaa" d="M45.359375,25H625.938" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="625.938" y="373.5" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2016</tspan></text><text x="529.2190597329986" y="373.5" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2015</tspan></text><text x="432.5001194659973" y="373.5" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2014</tspan></text><text x="335.7811791989959" y="373.5" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2013</tspan></text><text x="238.79725553400274" y="373.5" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2012</tspan></text><text x="142.07831526700136" y="373.5" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2011</tspan></text><text x="45.359375" y="373.5" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2010</tspan></text><path fill="#fad0c3" stroke="none" d="M45.359375,361C69.53911006675034,340,117.89858020025102,281.2,142.07831526700136,277C166.2580503337517,272.8,214.6175204672524,329.4971272229822,238.79725553400274,327.4C263.043236450251,325.29712722298217,311.5351982827476,262.30287277701774,335.7811791989959,260.2C359.9609142657463,258.10287277701775,408.3203843992469,303.25,432.5001194659973,310.6C456.67985453274764,317.95000000000005,505.03932466624826,314.8,529.2190597329986,319C553.398794799749,323.2,601.7582649332496,337.9,625.938,344.2L625.938,361L45.359375,361Z" fill-opacity="0.8" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 0.8;"></path><path fill="none" stroke="#fb9678" d="M45.359375,361C69.53911006675034,340,117.89858020025102,281.2,142.07831526700136,277C166.2580503337517,272.8,214.6175204672524,329.4971272229822,238.79725553400274,327.4C263.043236450251,325.29712722298217,311.5351982827476,262.30287277701774,335.7811791989959,260.2C359.9609142657463,258.10287277701775,408.3203843992469,303.25,432.5001194659973,310.6C456.67985453274764,317.95000000000005,505.03932466624826,314.8,529.2190597329986,319C553.398794799749,323.2,601.7582649332496,337.9,625.938,344.2" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><circle cx="45.359375" cy="361" r="0" fill="#fb9678" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="142.07831526700136" cy="277" r="0" fill="#fb9678" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="238.79725553400274" cy="327.4" r="0" fill="#fb9678" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="335.7811791989959" cy="260.2" r="0" fill="#fb9678" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="432.5001194659973" cy="310.6" r="0" fill="#fb9678" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="529.2190597329986" cy="319" r="0" fill="#fb9678" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="625.938" cy="344.2" r="0" fill="#fb9678" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><path fill="#afb1db" stroke="none" d="M45.359375,361C69.53911006675034,354.7,117.89858020025102,346.3,142.07831526700136,335.8C166.2580503337517,325.3,214.6175204672524,276.3708618331053,238.79725553400274,277C263.043236450251,277.6308618331053,311.5351982827476,334.5313816689466,335.7811791989959,340.84C359.9609142657463,347.13138166894663,408.3203843992469,341.67999999999995,432.5001194659973,327.4C456.67985453274764,313.12,505.03932466624826,224.5,529.2190597329986,226.6C553.398794799749,228.7,601.7582649332496,314.8,625.938,344.2L625.938,361L45.359375,361Z" fill-opacity="0.8" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 0.8;"></path><path fill="none" stroke="#7e81cb" d="M45.359375,361C69.53911006675034,354.7,117.89858020025102,346.3,142.07831526700136,335.8C166.2580503337517,325.3,214.6175204672524,276.3708618331053,238.79725553400274,277C263.043236450251,277.6308618331053,311.5351982827476,334.5313816689466,335.7811791989959,340.84C359.9609142657463,347.13138166894663,408.3203843992469,341.67999999999995,432.5001194659973,327.4C456.67985453274764,313.12,505.03932466624826,224.5,529.2190597329986,226.6C553.398794799749,228.7,601.7582649332496,314.8,625.938,344.2" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><circle cx="45.359375" cy="361" r="0" fill="#7e81cb" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="142.07831526700136" cy="335.8" r="0" fill="#7e81cb" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="238.79725553400274" cy="277" r="0" fill="#7e81cb" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="335.7811791989959" cy="340.84" r="0" fill="#7e81cb" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="432.5001194659973" cy="327.4" r="0" fill="#7e81cb" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="529.2190597329986" cy="226.6" r="0" fill="#7e81cb" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="625.938" cy="344.2" r="0" fill="#7e81cb" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><path fill="#0ddbe4" stroke="none" d="M45.359375,361C69.53911006675034,358.9,117.89858020025102,361,142.07831526700136,352.6C166.2580503337517,338.95000000000005,214.6175204672524,252.21942544459645,238.79725553400274,251.8C263.043236450251,251.37942544459645,311.5351982827476,360.8058002735978,335.7811791989959,349.24C359.9609142657463,337.70580027359784,408.3203843992469,166.33,432.5001194659973,159.4C456.67985453274764,152.47,505.03932466624826,270.7,529.2190597329986,293.8C553.398794799749,316.90000000000003,601.7582649332496,331.6,625.938,344.2L625.938,361L45.359375,361Z" fill-opacity="0.8" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 0.8;"></path><path fill="none" stroke="#01c0c8" d="M45.359375,361C69.53911006675034,358.9,117.89858020025102,361,142.07831526700136,352.6C166.2580503337517,338.95000000000005,214.6175204672524,252.21942544459645,238.79725553400274,251.8C263.043236450251,251.37942544459645,311.5351982827476,360.8058002735978,335.7811791989959,349.24C359.9609142657463,337.70580027359784,408.3203843992469,166.33,432.5001194659973,159.4C456.67985453274764,152.47,505.03932466624826,270.7,529.2190597329986,293.8C553.398794799749,316.90000000000003,601.7582649332496,331.6,625.938,344.2" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><circle cx="45.359375" cy="361" r="0" fill="#01c0c8" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="142.07831526700136" cy="352.6" r="0" fill="#01c0c8" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="238.79725553400274" cy="251.8" r="0" fill="#01c0c8" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="335.7811791989959" cy="349.24" r="0" fill="#01c0c8" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="432.5001194659973" cy="159.4" r="0" fill="#01c0c8" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="529.2190597329986" cy="293.8" r="0" fill="#01c0c8" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="625.938" cy="344.2" r="0" fill="#01c0c8" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle></svg><div class="morris-hover morris-default-style" style="left: 0px; top: 225px; display: none;"><div class="morris-hover-row-label">2010</div><div class="morris-hover-point" style="color: #fb9678">
  Site A:
  0
</div><div class="morris-hover-point" style="color: #7E81CB">
  Site B:
  0
</div><div class="morris-hover-point" style="color: #01C0C8">
  Site C:
  0
</div></div></div>
                            </div>
                        </div>
                    </div>
                    <!-- Morris chart end -->
                    <!-- Todo card start -->
                    <div class="col-md-12 col-xl-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>Create Your Daily Task</h5>
                                <label class="label label-success">Today</label>
                            </div>
                            <div class="card-block">
                                <div class="input-group input-group-button">
                                    <input type="text" class="form-control add_task_todo" placeholder="Create your task list" name="task-insert">
                                    <span class="input-group-addon" id="basic-addon1">
                              <button id="add-btn" class="btn btn-primary">Add Task</button>
                              </span>
                                </div>
                                <div class="new-task">
                                    <div class="to-do-list">
                                        <div class="checkbox-fade fade-in-primary">
                                            <label class="check-task">
                                                <input type="checkbox" value="">
                                                <span class="cr">
                                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                                <span>Hey.. Attach your new file</span>
                                            </label>
                                        </div>
                                        <div class="f-right">
                                            <a href="#!" class="delete_todolist"><i class="icofont icofont-ui-delete"></i></a>
                                        </div>
                                    </div>
                                    <div class="to-do-list">
                                        <div class="checkbox-fade fade-in-primary">
                                            <label class="check-task">
                                                <input type="checkbox" value="">
                                                <span class="cr">
                                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                                <span>New Attachment has error</span>
                                            </label>
                                        </div>
                                        <div class="f-right">
                                            <a href="#!" class="delete_todolist"><i class="icofont icofont-ui-delete"></i></a>
                                        </div>
                                    </div>
                                    <div class="to-do-list">
                                        <div class="checkbox-fade fade-in-primary">
                                            <label class="check-task">
                                                <input type="checkbox" value="">
                                                <span class="cr">
                                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                                <span>Have to submit early</span>
                                            </label>
                                        </div>
                                        <div class="f-right">
                                            <a href="#!" class="delete_todolist"><i class="icofont icofont-ui-delete"></i></a>
                                        </div>
                                    </div>
                                    <div class="to-do-list">
                                        <div class="checkbox-fade fade-in-primary">
                                            <label class="check-task">
                                                <input type="checkbox" value="">
                                                <span class="cr">
                                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                                <span>10 pages has to be completed</span>
                                            </label>
                                        </div>
                                        <div class="f-right">
                                            <a href="#!" class="delete_todolist"><i class="icofont icofont-ui-delete"></i></a>
                                        </div>
                                    </div>
                                    <div class="to-do-list">
                                        <div class="checkbox-fade fade-in-primary">
                                            <label class="check-task">
                                                <input type="checkbox" value="">
                                                <span class="cr">
                                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                                <span>Navigation working</span>
                                            </label>
                                        </div>
                                        <div class="f-right">
                                            <a href="#!" class="delete_todolist"><i class="icofont icofont-ui-delete"></i></a>
                                        </div>
                                    </div>
                                    <div class="to-do-list">
                                        <div class="checkbox-fade fade-in-primary">
                                            <label class="check-task">
                                                <input type="checkbox" value="">
                                                <span class="cr">
                                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                                <span>Files submited successfully</span>
                                            </label>
                                        </div>
                                        <div class="f-right">
                                            <a href="#!" class="delete_todolist"><i class="icofont icofont-ui-delete"></i></a>
                                        </div>
                                    </div>
                                    <div class="to-do-list">
                                        <div class="checkbox-fade fade-in-primary">
                                            <label class="check-task">
                                                <input type="checkbox" value="">
                                                <span class="cr">
                                    <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                    </span>
                                                <span>Work Complete Before Time</span>
                                            </label>
                                        </div>
                                        <div class="f-right">
                                            <a href="#!" class="delete_todolist"><i class="icofont icofont-ui-delete"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Todo card end -->
                    <!-- User chat box start -->
                    <div class="col-md-12 col-xl-4">
                        <div class="card widget-chat-box">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <i class="icofont icofont-navigation-menu pop-up"></i>
                                    </div>
                                    <div class="col-sm-8 text-center">
                                        <h5>
                                   John Henry
                                        </h5>
                                    </div>
                                    <div class="col-sm-2 text-right">
                                        <i class="icofont icofont-ui-edit"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-block">
                                <p class="text-center">12:05 A.M.</p>
                                <div class="media">
                                    <img class="d-flex mr-3 img-circle img-60 img-thumbnail" src="assets/images/user-card/img-round1.jpg" alt="Generic placeholder image">
                                    <div class="media-body send-chat">
                                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at
                                        <span class="time">3 min ago</span>
                                    </div>
                                </div>
                                <div class="media col-sm-8 offset-md-4">
                                    <div class="media-body  receive-chat">
                                        Cras sit amet nibh libero, in gravida nulla.vel metus scelerisque ante
                                        <span class="time">
                                        <i class="icofont icofont-check m-r-5"></i>Seen 2 sec ago
                                        </span>
                                    </div>
                                </div>
                                <div class="media">
                                    <img class="d-flex mr-3 img-circle img-60 img-thumbnail" src="assets/images/user-card/img-round1.jpg" alt="Generic placeholder image">
                                    <div class="media-body send-chat">
                                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at
                                        <span class="time">3 min ago</span>
                                    </div>
                                </div>                                                                
                            </div>
                            <div class="card-footer">
                                <input type="text" class="form-control" placeholder="Your Message">
                            </div>
                        </div>
                    </div>
                    <!-- User chat box end -->
                    <!-- Horizontal Timeline start -->
                    <div class="col-md-12 col-xl-8">
                        <div class="card">
                        <div class="card-header">
                            <h5>Steps To Follow</h5>
                        </div>
                            <div class="card-block">
                                <div class="cd-horizontal-timeline loaded">
                                    <div class="timeline">
                                        <div class="events-wrapper">
                                            <div class="events" style="width: 1800px;">
                                                <ol>
                                                    <li><a href="#0" data-date="16/01/2014" class="selected" style="left: 120px;">16 Jan</a></li>
                                                    <li><a href="#0" data-date="28/02/2014" style="left: 300px;">28 Feb</a></li>
                                                    <li><a href="#0" data-date="20/04/2014" style="left: 480px;">20 Mar</a></li>
                                                    <li><a href="#0" data-date="20/05/2014" style="left: 600px;">20 May</a></li>
                                                    <li><a href="#0" data-date="09/07/2014" style="left: 780px;">09 Jul</a></li>
                                                    <li><a href="#0" data-date="30/08/2014" style="left: 960px;">30 Aug</a></li>
                                                    <li><a href="#0" data-date="15/09/2014" style="left: 1020px;">15 Sep</a></li>
                                                    <li><a href="#0" data-date="01/11/2014" style="left: 1200px;">01 Nov</a></li>
                                                    <li><a href="#0" data-date="10/12/2014" style="left: 1380px;">10 Dec</a></li>
                                                    <li><a href="#0" data-date="19/01/2015" style="left: 1500px;">29 Jan</a></li>
                                                    <li><a href="#0" data-date="03/03/2015" style="left: 1680px;">3 Mar</a></li>
                                                </ol>
                                                <span class="filling-line" aria-hidden="true" style="transform: scaleX(0.0792925);"></span>
                                            </div>
                                            <!-- .events -->
                                        </div>
                                        <!-- .events-wrapper -->
                                        <ul class="cd-timeline-navigation">
                                            <li><a href="#0" class="prev inactive">Prev</a></li>
                                            <li><a href="#0" class="next">Next</a></li>
                                        </ul>
                                        <!-- .cd-timeline-navigation -->
                                    </div>
                                    <!-- .timeline -->
                                    <div class="events-content">
                                        <ol>
                                            <li class="selected" data-date="16/01/2014">
                                                <h2>Horizontal Timeline</h2>
                                                <em>January 16th, 2014</em>
                                                <p class="m-b-0">
                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
                                                </p>
                                                <div class="m-t-20 d-timeline-btn">
                                                    <button class="btn btn-danger">Read More</button>
                                                    <button class="btn btn-primary f-right"><i class="icofont icofont-plus m-r-0"></i></button>
                                                </div>
                                            </li>
                                            <li data-date="28/02/2014">
                                                <h2>Event title here</h2>
                                                <em>February 28th, 2014</em>
                                                <p class="m-b-0">
                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
                                                </p>
                                                <div class="m-t-20 d-timeline-btn">
                                                    <button class="btn btn-danger">Read More</button>
                                                    <button class="btn btn-primary f-right"><i class="icofont icofont-plus m-r-0"></i></button>
                                                </div>
                                            </li>
                                            <li data-date="20/04/2014">
                                                <h2>Event title here</h2>
                                                <em>March 20th, 2014</em>
                                                <p class="m-b-0">
                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
                                                </p>
                                                <div class="m-t-20 d-timeline-btn">
                                                    <button class="btn btn-danger">Read More</button>
                                                    <button class="btn btn-primary f-right"><i class="icofont icofont-plus m-r-0"></i></button>
                                                </div>
                                            </li>
                                            <li data-date="20/05/2014">
                                                <h2>Event title here</h2>
                                                <em>May 20th, 2014</em>
                                                <p class="m-b-0">
                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
                                                </p>
                                                <div class="m-t-20 d-timeline-btn">
                                                    <button class="btn btn-danger">Read More</button>
                                                    <button class="btn btn-primary f-right"><i class="icofont icofont-plus m-r-0"></i></button>
                                                </div>
                                            </li>
                                            <li data-date="09/07/2014">
                                                <h2>Event title here</h2>
                                                <em>July 9th, 2014</em>
                                                <p class="m-b-0">
                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
                                                </p>
                                                <div class="m-t-20 d-timeline-btn">
                                                    <button class="btn btn-danger">Read More</button>
                                                    <button class="btn btn-primary f-right"><i class="icofont icofont-plus m-r-0"></i></button>
                                                </div>
                                            </li>
                                            <li data-date="30/08/2014">
                                                <h2>Event title here</h2>
                                                <em>August 30th, 2014</em>
                                                <p class="m-b-0">
                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
                                                </p>
                                                <div class="m-t-20 d-timeline-btn">
                                                    <button class="btn btn-danger">Read More</button>
                                                    <button class="btn btn-primary f-right"><i class="icofont icofont-plus m-r-0"></i></button>
                                                </div>
                                            </li>
                                            <li data-date="15/09/2014">
                                                <h2>Event title here</h2>
                                                <em>September 15th, 2014</em>
                                                <p class="m-b-0">
                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
                                                </p>
                                                <div class="m-t-20 d-timeline-btn">
                                                    <button class="btn btn-danger">Read More</button>
                                                    <button class="btn btn-primary f-right"><i class="icofont icofont-plus m-r-0"></i></button>
                                                </div>
                                            </li>
                                            <li data-date="01/11/2014">
                                                <h2>Event title here</h2>
                                                <em>November 1st, 2014</em>
                                                <p class="m-b-0">
                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
                                                </p>
                                                <div class="m-t-20 d-timeline-btn">
                                                    <button class="btn btn-danger">Read More</button>
                                                    <button class="btn btn-primary f-right"><i class="icofont icofont-plus m-r-0"></i></button>
                                                </div>
                                            </li>
                                            <li data-date="10/12/2014">
                                                <h2>Event title here</h2>
                                                <em>December 10th, 2014</em>
                                                <p class="m-b-0">
                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
                                                </p>
                                                <div class="m-t-20 d-timeline-btn">
                                                    <button class="btn btn-danger">Read More</button>
                                                    <button class="btn btn-primary f-right"><i class="icofont icofont-plus m-r-0"></i></button>
                                                </div>
                                            </li>
                                            <li data-date="19/01/2015">
                                                <h2>Event title here</h2>
                                                <em>January 19th, 2015</em>
                                                <p class="m-b-0">
                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
                                                </p>
                                                <div class="m-t-20 d-timeline-btn">
                                                    <button class="btn btn-danger">Read More</button>
                                                    <button class="btn btn-primary f-right"><i class="icofont icofont-plus m-r-0"></i></button>
                                                </div>
                                            </li>
                                            <li data-date="03/03/2015">
                                                <h2>Event title here</h2>
                                                <em>March 3rd, 2015</em>
                                                <p class="m-b-0">
                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.
                                                </p>
                                                <div class="m-t-20 d-timeline-btn">
                                                    <button class="btn btn-danger">Read More</button>
                                                    <button class="btn btn-primary f-right"><i class="icofont icofont-plus m-r-0"></i></button>
                                                </div>
                                            </li>
                                        </ol>
                                    </div>
                                    <!-- .events-content -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Horizontal Timeline end -->
                </div>
            </div>
        </div>
    </div>
@endsection