@extends('layouts/mobile')

@section('content')
<about-me inline-template>
<div class="row">
    <div class="m-people col-md-4 col-md-offset-4">
        <span class="m-back"><a href="/mobile-home"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></span>
        <div class="panel panel-content panel-default page-about-me">
            <div class="panel-heading">
                <div class="about-me-heading">
                    <h1 class="text-center" style="font-size:60px"><i class="fa fa-user-circle-o" aria-hidden="true"></i></h1>
                    <h2 class="text-center">{{ $user->name }}</h2>
                </div>
            </div>
            <div class="panel-body">
            <form role="form" enctype="multipart/form-data" method="post" action="/appointment/create">
            {{ csrf_field() }}
                <div class="row about-me-row">
                    <div class="col-xs-4">
                        <label class="label-image" for="home"><img src="/img/icon-home.svg" alt="Home" class="img-responsive"></label>
                    </div>
                    <div class="col-xs-8">
                        <label>I live at</label>
                        <div class="form-input" v-if="mode_edit['home_edit']">
                            <vue-google-autocomplete
                                id="home-place"
                                classname="form-control"
                                placeholder=""
                                v-on:placechanged="getHomeAddressData"
                            >
                            </vue-google-autocomplete>
                            <a href="javascript:void(0)" v-on:click="saveMyData">+ Add a place or organisation</a>
                        </div>
                        <span class="help-block">
                            {{$errors->first('home')}}
                        </span>
                    </div>
                </div>
                <div class="row about-me-row">
                    <label class="icon" v-on:click="toggleShow('work_edit')"><i class="fa fa-briefcase" aria-hidden="true"></i></label>
                    <label>
                        <p>I work at</p>
                        <p class="pvalue" v-if="!mode_edit['work_edit']">50 Carrington Street, Sydney</p>
                        <div class="form-input" v-if="mode_edit['work_edit']">
                            <vue-google-autocomplete
                                id="work-place"
                                classname="form-control"
                                placeholder=""
                                v-on:placechanged="getWorkAddressData"
                            >
                            </vue-google-autocomplete>
                            <a href="javascript:void(0)">+ Add a place or organisation</a>
                        </div>
                    </label>
                </div>
                <div class="row">
                    <a class="btn btn-primary" data-toggle="collapse" href="#collapse-my-fav-things">
                        <i class="fa fa-check" aria-hidden="true"></i> My favorite things
                    </a>
                </div>
                <div class="row panel-collapse collapse" id="collapse-my-fav-things">
                    <div class="about-me-row">
                        <label class="icon" v-on:click="toggleShow('favman_edit')"><i class="fa fa-user-o" aria-hidden="true"></i></label>
                        <label v-if="!mode_edit['favman_edit']">People</label>
                        <div class="form-input" v-if="mode_edit['favman_edit']">
                            <input type="text" class="form-control"/>
                            <a href="javascript:void(0)">+ Add a person</a>
                        </div>
                    </div>
                    <div class="about-me-row">
                        <label class="icon" v-on:click="toggleShow('favfilm_edit')"><i class="fa fa-video-camera" aria-hidden="true"></i></label>
                        <label v-if="!mode_edit['favfilm_edit']">Movies</label>
                        <div class="form-input" v-if="mode_edit['favfilm_edit']">
                            <input type="text" class="form-control"/>
                            <a href="javascript:void(0)">+ Add a movie</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <a class="btn btn-success" data-toggle="collapse" href="#collapse-my-health">
                        <i class="fa fa-stethoscope" aria-hidden="true"></i> My health
                    </a>
                </div>
                <div class="row panel-collapse collapse" id="collapse-my-health">
                    <div class="about-me-row">
                        <label class="icon"><i class="fa fa-heart-o" aria-hidden="true"></i></label>
                        <label>
                            <p>My medication is</p>
                            <p>Pills</p>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <button class="btn btn-success"><i class="fa fa-users" aria-hidden="true"></i> My favorite people</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
</about-me>
@endsection