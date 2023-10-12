@extends('backend.master')

@section('title', 'Website Settings')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-cogs"></i>
                Website Settings
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-4 col-sm-2 general-settings">
                    <div class="nav flex-column nav-tabs h-100 vertical-nav-tabs" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link {{ @$_GET['active-tab'] == 'website-info' ? 'active' : '' }}" id="vert-tabs-1"
                            data-toggle="pill" href="#tabs-1" role="tab" aria-controls="tabs-1" aria-selected="true">
                            <i class="fas fa-desktop"></i>
                            &nbsp;Website Info
                        </a>
                        <a class="nav-link {{ @$_GET['active-tab'] == 'style-settings' ? 'active' : '' }}" id="vert-tabs-4"
                            data-toggle="pill" href="#tabs-4" role="tab" aria-controls="tabs-4" aria-selected="false">
                            <i class="fas fa-swatchbook"></i>
                            &nbsp;Logo &amp; Icon
                        </a>
                        <a class="nav-link {{ @$_GET['active-tab'] == 'contacts' ? 'active' : '' }}" id="vert-tabs-2"
                            data-toggle="pill" href="#tabs-2" role="tab" aria-controls="tabs-2" aria-selected="false">
                            <i class="fas fa-address-book"></i>
                            &nbsp;Contacts
                        </a>
                        <a class="nav-link {{ @$_GET['active-tab'] == 'social-links' ? 'active' : '' }}" id="vert-tabs-3"
                            data-toggle="pill" href="#tabs-3" role="tab" aria-controls="tabs-3" aria-selected="false">
                            <i class="fas fa-share-alt"></i>
                            &nbsp;Social Links
                        </a>

                        <a class="nav-link {{ @$_GET['active-tab'] == 'custom-css' ? 'active' : '' }}" id="vert-tabs-5"
                            data-toggle="pill" href="#tabs-5" role="tab" aria-controls="tabs-5" aria-selected="false">
                            <i class="fas fa-code"></i>
                            &nbsp;Custom CSS
                        </a>
                        {{-- <a class="nav-link {{ @$_GET['active-tab'] == 'notification-settings' ? 'active' : '' }}" id="vert-tabs-6"
                    data-toggle="pill" href="#tabs-6" role="tab" aria-controls="tabs-6" aria-selected="false">
                    <i class="fas fa-envelope"></i>
                    &nbsp;Notification Settings
                </a> --}}
                        {{-- <a class="nav-link {{ @$_GET['active-tab'] == 'website-status' ? 'active' : '' }}" id="vert-tabs-7"
                    data-toggle="pill" href="#tabs-7" role="tab" aria-controls="tabs-7" aria-selected="false">
                    <i class="fas fa-power-off"></i>
                    &nbsp;Website Status
                </a> --}}
                    </div>
                </div>
                <div class="col-8 col-sm-10">
                    <div class="tab-content" id="vert-tabs-tabContent">
                        <div class="tab-pane fade {{ @$_GET['active-tab'] == 'website-info' ? 'active show' : '' }}"
                            id="tabs-1" role="tabpanel" aria-labelledby="vert-tabs-1">

                            <form action="{{ route('backend.admin.settings.website.info.update') }}" method="post">
                                @csrf
                                <div class="col-md-12 d-flex justify-content-between border-bottom mb-2">
                                    <h5>
                                        <i class="fas fa-desktop"></i>
                                        &nbsp;&nbsp;Website Info
                                    </h5>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Website Title</label>
                                        <input class="form-control" name="site_name" type="text"
                                            value="{{ readConfig('site_name') }}" placeholder="Enter Site Title">
                                    </div>
                                    <div class="form-group">
                                        <label>Sub Title</label>
                                        <input class="form-control" name="sub_title" type="text"
                                            value="{{ readConfig('sub_title') }}" placeholder="Enter Sub Title">
                                    </div>
                                    <div class="form-group">
                                        <label>Short Description</label>
                                        <textarea class="form-control" rows="2" name="short_description" cols="50"
                                            placeholder="Enter Short Description">{{ readConfig('short_description') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Meta Description</label>
                                        <textarea class="form-control" rows="2" name="meta_description" cols="50"
                                            placeholder="Enter Meta Description">{{ readConfig('meta_description') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Meta Keywords</label>
                                        <textarea class="form-control" rows="2" name="meta_keywords" cols="50" placeholder="Enter Keywords">{{ readConfig('meta_keywords') }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Website URL</label>
                                        <input class="form-control" name="site_url" type="url"
                                            value="{{ readConfig('site_url') }}" placeholder="Enter Site URL">
                                    </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <button type="submit" class="btn bg-gradient-primary">
                                        <i class="fas fa-save"></i>
                                        &nbsp;Save Changes
                                    </button>
                                </div>
                            </form>

                        </div>
                        <div class="tab-pane fade {{ @$_GET['active-tab'] == 'contacts' ? 'active show' : '' }}"
                            id="tabs-2" role="tabpanel" aria-labelledby="vert-tabs-2">

                            <form action="{{ route('backend.admin.settings.website.contacts.update') }}" method="post">
                                @csrf
                                <div class="col-md-12 d-flex justify-content-between border-bottom mb-2">
                                    <h5>
                                        <i class="fas fa-address-book"></i>
                                        &nbsp;&nbsp;Contacts
                                    </h5>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input placeholder="" class="form-control" name="contact_address" type="text"
                                            value="{{ readConfig('contact_address') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Mobile</label>
                                        <input placeholder="Mobile" class="form-control" name="contact_mobile"
                                            type="tel" value="{{ readConfig('contact_mobile') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input placeholder="Phone" class="form-control" name="contact_phone"
                                            type="tel" value="{{ readConfig('contact_phone') }}">
                                    </div>

                                    <div class="form-group">
                                        <label>Email</label>
                                        <input placeholder="Email" class="form-control" name="contact_email"
                                            type="email" value="{{ readConfig('contact_email') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Working Time</label>
                                        <input placeholder="Sunday to Thursday 08:00 AM to 05:00 PM" class="form-control"
                                            name="working_hour" type="text" value="{{ readConfig('working_hour') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Google Map (Embed Iframe)</label>
                                        <input placeholder="Google Embed Iframe" class="form-control" name="google_map"
                                            type="text" value="{{ readConfig('google_map') }}">
                                    </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <button type="submit" class="btn bg-gradient-primary">
                                        <i class="fas fa-save"></i>
                                        &nbsp;Save Changes
                                    </button>
                                </div>
                            </form>

                        </div>
                        <div class="tab-pane fade {{ @$_GET['active-tab'] == 'social-links' ? 'active show' : '' }}"
                            id="tabs-3" role="tabpanel" aria-labelledby="vert-tabs-3">
                            <form action="{{ route('backend.admin.settings.website.social.link.update') }}"
                                method="post">
                                @csrf
                                <div class="col-md-12 d-flex justify-content-between border-bottom mb-2">
                                    <h5>
                                        <i class="fas fa-share-alt"></i>
                                        &nbsp;&nbsp;Social Links
                                    </h5>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>
                                            <i class="fab fa-facebook"></i>
                                            &nbsp; Facebook
                                        </label>
                                        <input placeholder="Facebook" class="form-control" name="facebook_link"
                                            type="url" value="{{ readConfig('facebook_link') }}">
                                    </div>

                                    <div class="form-group">
                                        <label>
                                            <i class="fab fa-twitter"></i>
                                            &nbsp; Twitter
                                        </label>
                                        <input placeholder="Twitter" class="form-control" name="twitter_link"
                                            type="url" value="{{ readConfig('twitter_link') }}">
                                    </div>

                                    <div class="form-group">
                                        <label>
                                            <i class="fab fa-linkedin"></i>
                                            &nbsp; Linkedin
                                        </label>
                                        <input placeholder="Linkedin" class="form-control" name="linkedin_link"
                                            type="url" value="{{ readConfig('linkedin_link') }}">
                                    </div>

                                    <div class="form-group">
                                        <label>
                                            <i class="fab fa-youtube"></i>
                                            &nbsp; Youtube
                                        </label>
                                        <input placeholder="Youtube" class="form-control" name="youtube_link"
                                            type="url" value="{{ readConfig('youtube_link') }}">
                                    </div>

                                    <div class="form-group">
                                        <label>
                                            <i class="fab fa-instagram"></i>
                                            &nbsp; Instagram
                                        </label>
                                        <input placeholder="Instagram" class="form-control" name="instagram_link"
                                            type="url" value="{{ readConfig('instagram_link') }}">
                                    </div>

                                    <div class="form-group">
                                        <label>
                                            <i class="fab fa-pinterest"></i>
                                            &nbsp; Pinterest
                                        </label>
                                        <input placeholder="Pinterest" class="form-control" name="pinterest_link"
                                            type="url" value="{{ readConfig('pinterest_link') }}">
                                    </div>

                                    <div class="form-group">
                                        <label>
                                            <i class="fab fa-tumblr"></i>
                                            &nbsp; Tumblr
                                        </label>
                                        <input placeholder="Tumblr" class="form-control" name="tumblr_link"
                                            type="url" value="{{ readConfig('tumblr_link') }}">
                                    </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <button type="submit" class="btn bg-gradient-primary">
                                        <i class="fas fa-save"></i>
                                        &nbsp;Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade {{ @$_GET['active-tab'] == 'style-settings' ? 'active show' : '' }}"
                            id="tabs-4" role="tabpanel" aria-labelledby="vert-tabs-4">

                            <form action="{{ route('backend.admin.settings.website.style.settings.update') }}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12 d-flex justify-content-between border-bottom">
                                    <h5>
                                        <i class="fas fa-swatchbook"></i>
                                        &nbsp;&nbsp;Logo &amp; Icon
                                    </h5>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6 my-2">
                                        <label for="thumbnail"> Site Logo : </label>
                                        <div class="col-md-6">
                                            <label class="post_upload" for="file" style="height: 100px">
                                                @if (readconfig('site_logo') != null)
                                                    <img id="image_load"
                                                        src='{{ imageRecover(readconfig('site_logo')) }}'
                                                        class="img-responsive">
                                                @else
                                                    <img id="image_load" src="{{ asset('assets/images/photo.png') }}">
                                                @endif
                                            </label>
                                            {{ Form::file('site_logo', ['id' => 'file', 'style' => 'display:none', 'onchange' => "photoLoad(this,'image_load')"]) }}
                                        </div>
                                        <small>
                                            <i class="far fa-question-circle"></i>
                                            ( 260x60 px ) - Extensions: .png, .jpg, .jpeg, .gif, .svg
                                        </small>
                                    </div>
                                    <div class="col-md-6 my-2">
                                        <label for="thumbnail"> Favicon : </label>
                                        <div class="col-md-6">
                                            <label class="post_upload" for="file2"
                                                style="height: 100px; width: 100px">
                                                @if (readconfig('favicon_icon') != null)
                                                    <img id="fav_image_load"
                                                        src='{{ imageRecover(readconfig('favicon_icon')) }}'
                                                        class="img-responsive">
                                                @else
                                                    <img id="fav_image_load"
                                                        src="{{ asset('assets/images/photo.png') }}">
                                                @endif
                                            </label>
                                            {{ Form::file('favicon_icon', ['id' => 'file2', 'style' => 'display:none', 'onchange' => "photoLoad(this,'fav_image_load')"]) }}
                                        </div>
                                        <small>
                                            <i class="far fa-question-circle"></i>
                                            ( 50x50 px ) - Extensions: .png, .jpg, .jpeg, .gif, .svg
                                        </small>
                                    </div>
                                </div>
                                <button type="submit" class="btn bg-gradient-primary mb-2">
                                    <i class="fas fa-save"></i>
                                    &nbsp;Save Changes
                                </button>
                            </form>
                        </div>
                        <div class="tab-pane fade {{ @$_GET['active-tab'] == 'custom-css' ? 'active show' : '' }}"
                            id="tabs-5" role="tabpanel" aria-labelledby="vert-tabs-5">
                            <form action="{{ route('backend.admin.settings.website.custom.css.update') }}"
                                method="post">
                                @csrf
                                <div class="col-md-12 d-flex justify-content-between border-bottom mb-2">
                                    <h5>
                                        <i class="fas fa-code"></i>
                                        &nbsp;&nbsp;Custom CSS
                                    </h5>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <div class="form-group">
                                        <textarea placeholder="" class="form-control" rows="17" name="custom_css" cols="50">{{ readConfig('custom_css') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <button type="submit" class="btn bg-gradient-primary">
                                        <i class="fas fa-save"></i>
                                        &nbsp;Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade {{ @$_GET['active-tab'] == 'notification-settings' ? 'active show' : '' }}"
                            id="tabs-6" role="tabpanel" aria-labelledby="vert-tabs-6">
                            <form action="{{ route('backend.admin.settings.website.notification.settings.update') }}"
                                method="post">
                                @csrf
                                <div class="col-md-12 d-flex justify-content-between border-bottom mb-2">
                                    <h5>
                                        <i class="fas fa-envelope"></i>
                                        &nbsp;&nbsp;Notification Settings
                                    </h5>
                                </div>
                                <div class="p-a-md col-md-12">
                                    <div class="form-group">
                                        <label>Website Notification Email</label>
                                        <input placeholder="Enter email" class="form-control" name="notify_email_address"
                                            type="email" value="{{ readConfig('notify_email_address') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Send me an email on new contact Messages : </label>
                                        <div class="radio bg-white rounded pt-2 pl-2 border">
                                            <label class="ui-check ui-check-md">
                                                <input {{ readConfig('notify_messages_status') == 1 ? 'checked' : '' }}
                                                    name="notify_messages_status" type="radio" value="1">
                                                <i class="dark-white"></i>
                                                Yes
                                            </label>
                                            &nbsp; &nbsp;
                                            <label class="ui-check ui-check-md">
                                                <input {{ readConfig('notify_messages_status') == 0 ? 'checked' : '' }}
                                                    name="notify_messages_status" type="radio" value="0">
                                                <i class="dark-white"></i>
                                                No
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Send me an email on new Comments : </label>
                                        <div class="radio bg-white rounded pt-2 pl-2 border">
                                            <label class="ui-check ui-check-md">
                                                <input {{ readConfig('notify_comments_status') == 1 ? 'checked' : '' }}
                                                    name="notify_comments_status" type="radio" value="1">
                                                <i class="dark-white"></i>
                                                Yes
                                            </label>
                                            &nbsp; &nbsp;
                                            <label class="ui-check ui-check-md">
                                                <input {{ readConfig('notify_comments_status') == 0 ? 'checked' : '' }}
                                                    name="notify_comments_status" type="radio" value="0">
                                                <i class="dark-white"></i>
                                                No
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <button type="submit" class="btn bg-gradient-primary">
                                        <i class="fas fa-save"></i>
                                        &nbsp;Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade {{ @$_GET['active-tab'] == 'website-status' ? 'active show' : '' }}"
                            id="tabs-7" role="tabpanel" aria-labelledby="vert-tabs-7">
                            <form action="{{ route('backend.admin.settings.website.status.update') }}" method="post">
                                @csrf
                                <div class="col-md-12 d-flex justify-content-between border-bottom mb-2">
                                    <h5>
                                        <i class="fas fa-power-off"></i>
                                        &nbsp;&nbsp;Website Status
                                    </h5>
                                </div>
                                <div class="p-a-md col-md-12">
                                    <div class="form-group">
                                        <label>Website Status : </label>
                                        <div class="radio bg-white rounded pt-2 pl-2 border">
                                            <label class="ui-check ui-check-md">
                                                <input {{ readConfig('is_live') == 1 ? 'checked' : '' }} name="is_live"
                                                    type="radio" value="1">
                                                <i class="dark-white"></i>
                                                Active
                                            </label>
                                            &nbsp; &nbsp;
                                            <label class="ui-check ui-check-md">
                                                <input {{ readConfig('is_live') == 0 ? 'checked' : '' }} name="is_live"
                                                    type="radio" value="0">
                                                <i class="dark-white"></i>
                                                Not Active
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group {{ readConfig('is_live') == 1 ? 'd-none' : '' }}"
                                        id="close_msg_div">
                                        <label>Close Message</label>
                                        <textarea placeholder="Close Message" class="form-control" rows="4" name="close_msg" cols="50">Website under maintenance&lt;h1&gt;Comming SOON&lt;/h1&gt;</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <button type="submit" class="btn bg-gradient-primary">
                                        <i class="fas fa-save"></i>
                                        &nbsp;Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        $('input[type=radio][name=is_live]').on("change", function() {
            if (this.value == '0') {
                $("#close_msg_div").removeClass('d-none');
            } else {
                $("#close_msg_div").addClass('d-none');
            }
        });
    </script>
@endpush
