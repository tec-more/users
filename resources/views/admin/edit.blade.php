@extends('tukecx-core::admin._master')

@section('css')

@endsection

@section('js')

@endsection

@section('js-init')

@endsection

@section('content')
    <div class="layout-2columns sidebar-left">
        <div class="column left">
            @php do_action('meta_boxes', 'top-sidebar', 'user', $object) @endphp
            @include('tukecx-users::admin._partials._profile-sidebar')
            @php do_action('meta_boxes', 'bottom-sidebar', 'user', $object) @endphp
        </div>
        <div class="column main">
            @php
                $curentTab = Request::get('_tab', 'user_profiles');
            @endphp
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs tab-change-url">
                    <li class="{{ $curentTab === 'user_profiles' ? 'active' : '' }}">
                        <a data-target="#user_profiles"
                           data-toggle="tab"
                           href="{{ Request::url() }}?_tab=user_profiles"
                           aria-expanded="false">用户简介</a>
                    </li>
                    <li class="{{ $curentTab === 'change_avatar' ? 'active' : '' }}">
                        <a data-target="#change_avatar"
                           data-toggle="tab"
                           href="{{ Request::url() }}?_tab=change_avatar"
                           aria-expanded="false">头像</a>
                    </li>
                    <li class="{{ $curentTab === 'change_password' ? 'active' : '' }}">
                        <a data-target="#change_password"
                           data-toggle="tab"
                           href="{{ Request::url() }}?_tab=change_password"
                           aria-expanded="false">密码</a>
                    </li>
                    @if(!$isLoggedInUser && isset($roles))
                        <li class="{{ $curentTab === 'roles' ? 'active' : '' }}">
                            <a data-target="#roles"
                               data-toggle="tab"
                               href="{{ Request::url() }}?_tab=roles"
                               aria-expanded="false">角色</a>
                        </li>
                    @endif
                    @php do_action('meta_boxes', 'user-tab-links', 'user', $object) @endphp
                </ul>
                <div class="tab-content">
                    <div class="tab-pane {{ $curentTab === 'user_profiles' ? 'active' : '' }}" id="user_profiles">
                        {!! Form::open(['class' => 'js-validate-form']) !!}
                        {!! Form::hidden('_tab', 'user_profiles') !!}
                        <div class="form-group">
                            <label class="control-label "><b>显示名</b></label>
                            <input type="text" value="{{ $object->display_name or '' }}"
                                   name="display_name"
                                   autocomplete="off"
                                   class="form-control"/>
                        </div>
                        @if((!isset($object->id)) || !$object->id)
                            <div class="form-group">
                                <label class="control-label "><b>密码</b></label>
                                <input type="text" value=""
                                       name="password"
                                       autocomplete="off"
                                       class="form-control"/>
                            </div>
                        @endif
                        <div class="form-group">
                            <label class="control-label "><b>姓</b></label>
                            <input type="text" value="{{ $object->first_name or '' }}"
                                   name="first_name"
                                   autocomplete="off"
                                   class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><b>名</b></label>
                            <input type="text" value="{{ $object->last_name or '' }}"
                                   name="last_name"
                                   autocomplete="off"
                                   class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><b>电话</b></label>
                            <input type="text" value="{{ $object->phone or '' }}"
                                   name="phone"
                                   autocomplete="off"
                                   class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><b>手机</b></label>
                            <input type="text" value="{{ $object->mobile_phone or '' }}"
                                   name="mobile_phone"
                                   autocomplete="off"
                                   class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><b>性别</b></label>
                            @php
                                $selected = isset($object->sex) ?  $object->sex : 'female';
                            @endphp
                            {!! Form::customRadio('sex', [
                                ['male', 'Male'],
                                ['female', 'Female'],
                                ['other', 'Other'],
                            ], $selected) !!}
                        </div>
                        <div class="form-group">
                            <label class="control-label"><b>生日</b></label>
                            <input type="text"
                                   value="{{ isset($object->birthday) && $object->birthday ? convert_timestamp_format($object->birthday, 'Y-m-d') : '' }}"
                                   name="birthday"
                                   data-date-format="yyyy-mm-dd"
                                   autocomplete="off"
                                   readonly
                                   class="form-control js-date-picker input-medium"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><b>关于</b></label>
                            <textarea class="form-control"
                                      name="description"
                                      rows="5">{!! $object->description or '' !!}</textarea>
                        </div>
                        <div class="mt10 text-right">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-check"></i> 保存
                            </button>
                            <button class="btn btn-success" type="submit"
                                    name="_continue_edit" value="1">
                                <i class="fa fa-check"></i> 保存继续
                            </button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="tab-pane {{ $curentTab === 'change_avatar' ? 'active' : '' }}" id="change_avatar">
                        {!! Form::open(['class' => 'js-validate-form']) !!}
                        {!! Form::hidden('_tab', 'change_avatar') !!}
                        <div class="form-group">
                            {!! Form::selectImageBox('avatar', (isset($object->avatar) ? $object->avatar : '')) !!}
                        </div>
                        <div class="mt10 text-right">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-check"></i> 保存
                            </button>
                            <button class="btn btn-success" type="submit"
                                    name="_continue_edit" value="1">
                                <i class="fa fa-check"></i> 保存继续
                            </button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="tab-pane {{ $curentTab === 'change_password' ? 'active' : '' }}" id="change_password">
                        {!! Form::open(['class' => 'js-validate-form', 'url' => route('admin::users.update-password.post', ['id' => $object->id])]) !!}
                        {!! Form::hidden('_tab', 'change_password') !!}
                        <div class="form-group">
                            <label>
                                <b>新密码 <span class="text-danger">(*)</span></b>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-lock"></i>
                                </span>
                                {!! Form::password('password', [
                                    'class' => 'form-control',
                                    'id' => 'password',
                                    'autocomplete' => 'off',
                                ]) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                <b>确认密码 <span class="text-danger">(*)</span></b>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-lock"></i>
                                </span>
                                {!! Form::password('password_confirmation', [
                                    'class' => 'form-control',
                                    'id' => 'password_confirmation',
                                    'autocomplete' => 'off',
                                ]) !!}
                            </div>
                        </div>
                        <div class="mt10 text-right">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-check"></i> 保存
                            </button>
                            <button class="btn btn-success" type="submit"
                                    name="_continue_edit" value="1">
                                <i class="fa fa-check"></i> 保存继续
                            </button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    @if(!$isLoggedInUser && isset($roles))
                        <div class="tab-pane {{ $curentTab === 'roles' ? 'active' : '' }}" id="roles">
                            {!! Form::open(['class' => 'js-validate-form']) !!}
                            {!! Form::hidden('_tab', 'roles') !!}
                            <div class="form-group">
                                <div class="scroller form-control height-auto"
                                     style="height: 400px;"
                                     data-always-visible="1"
                                     data-rail-visible1="1">
                                    <div class="pad-top-5 pad-bot-5 pad-left-5">
                                        {!! Form::customCheckbox($roles) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="mt10 text-right">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa fa-check"></i> 保存
                                </button>
                                <button class="btn btn-success" type="submit"
                                        name="_continue_edit" value="1">
                                    <i class="fa fa-check"></i> 保存继续
                                </button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    @endif
                    @php do_action('meta_boxes', 'user-tab-pane', 'user', $object) @endphp
                </div>
            </div>
            @php do_action('meta_boxes', 'main', 'user', $object) @endphp
        </div>
    </div>
@endsection
