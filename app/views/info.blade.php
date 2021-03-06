@extends('layout')

@section('main')

    <h1 class="page-header">Jeopardy API - Guide</h1>
    <div class="well" style="margin-bottom: 0;">
        Here you can see the information about the available routes for the API.<br>
        Click the red lightningbolts to see examples of the data needed to be send,
        and the results you can expect to get back.
    </div>

    <div class="row">
        <div class="col-md-12">

            <hr>
            <h4>Token</h4>
            <table class="table table-bordered table-hover">
                <thead>
                    @include('tableheaders')
                </thead>
                <tbody>
                    <tr>
                        <td class="action-create">Create</td>
                        <td>POST</td>
                        <td>{{ $url_prefix }}/token</td>
                        <td>{{ $icon->auth->off }}</td>
                        <td>
                            {{ $icon->example->on }}
                            <pre class="example">{"email": "martindilling@gmail.com", "password": "password"}</pre>
                        </td>
                        <td>
                            {{ $icon->example->on }}
                            <pre class="example">{"token":"23O7hGf02WaQZENFThJH3uXkOKu20UAL","user":{"id":1,"email":"martindilling@gmail.com","name":"Martin Dilling-Hansen","created_at":"2013-12-16 00:01:43","updated_at":"2014-02-27 04:34:21"}}</pre>
                        </td>
                        <td>201</td>
                        <td>{{ $icon->done->true }}</td>
                    </tr>
                    <tr>
                        <td class="action-read">Read</td>
                        <td>GET</td>
                        <td>{{ $url_prefix }}/token</td>
                        <td>{{ $icon->auth->on }}</td>
                        <td>
                            {{ $icon->example->none }}
                            <pre class="example"></pre>
                        </td>
                        <td>
                            {{ $icon->example->on }}
                            <pre class="example">{"data":{"id":1,"email":"martindilling@gmail.com","name":"Martin Dilling-Hansen","created_at":"2013-12-16 00:01:43","updated_at":"2014-02-27 04:34:21"},"embeds":["games"]}</pre>
                        </td>
                        <td>200</td>
                        <td>{{ $icon->done->true }}</td>
                    </tr>
                    <tr>
                        <td class="action-delete">Delete</td>
                        <td>DELETE</td>
                        <td>{{ $url_prefix }}/token</td>
                        <td>{{ $icon->auth->on }}</td>
                        <td>
                            {{ $icon->example->none }}
                            <pre class="example"></pre>
                        </td>
                        <td>
                            {{ $icon->example->none }}
                            <pre class="example"></pre>
                        </td>
                        <td>204</td>
                        <td>{{ $icon->done->true }}</td>
                    </tr>
                </tbody>
            </table>

            <hr>
            <h4>Users</h4>
            <table class="table table-bordered table-hover">
                <thead>
                    @include('tableheaders')
                </thead>
                <tbody>
                <tr>
                    <td class="action-create">Create</td>
                    <td>POST</td>
                    <td>{{ $url_prefix }}/users</td>
                    <td>{{ $icon->auth->off }}</td>
                    <td>
                        {{ $icon->example->on }}
                        <pre class="example">{"email": "someuser@example.com", "password": "somepassword", "name": "Some User"}</pre>
                    </td>
                    <td>
                        {{ $icon->example->on }}
                        <pre class="example">{"data":{"id":27,"email":"someuser@example.com","name":"Some User","created_at":"2014-02-28 01:53:06","updated_at":"2014-02-28 01:53:06"},"embeds":["games"]}</pre>
                    </td>
                    <td>201</td>
                    <td>{{ $icon->done->true }}</td>
                </tr>
                <tr>
                    <td class="action-read">Read</td>
                    <td>GET</td>
                    <td>{{ $url_prefix }}/profile</td>
                    <td>{{ $icon->auth->on }}</td>
                    <td>
                        {{ $icon->example->none }}
                        <pre class="example"></pre>
                    </td>
                    <td>
                        {{ $icon->example->on }}
                        <pre class="example">{"data":{"id":1,"email":"martindilling@gmail.com","name":"Martin Dilling-Hansen","created_at":"2013-12-16 00:01:43","updated_at":"2014-02-27 04:34:21"},"embeds":["games"]}</pre>
                    </td>
                    <td>200</td>
                    <td>{{ $icon->done->true }}</td>
                </tr>
                <tr>
                    <td class="action-update">Update</td>
                    <td>POST</td>
                    <td>{{ $url_prefix }}/profile</td>
                    <td>{{ $icon->auth->on }}</td>
                    <td>
                        {{ $icon->example->off }}
                        <pre class="example"></pre>
                    </td>
                    <td>
                        {{ $icon->example->off }}
                        <pre class="example"></pre>
                    </td>
                    <td>200</td>
                    <td>{{ $icon->done->false }}</td>
                </tr>
                <tr>
                    <td class="action-delete">Delete</td>
                    <td>DELETE</td>
                    <td>{{ $url_prefix }}/profile</td>
                    <td>{{ $icon->auth->on }}</td>
                    <td>
                        {{ $icon->example->none }}
                        <pre class="example"></pre>
                    </td>
                    <td>
                        {{ $icon->example->none }}
                        <pre class="example"></pre>
                    </td>
                    <td>204</td>
                    <td>{{ $icon->done->false }}</td>
                </tr>
                <tr>
                    <td class="action-list">List</td>
                    <td>GET</td>
                    <td>{{ $url_prefix }}/profile/games</td>
                    <td>{{ $icon->auth->on }}</td>
                    <td>
                        {{ $icon->example->none }}
                        <pre class="example"></pre>
                    </td>
                    <td>
                        {{ $icon->example->on }}
                        <pre class="example">{"data":[{"id":1,"user_id":1,"active":true,"name":"Quia culpa.","answer_time":100,"created_at":"2014-02-28 01:58:20","updated_at":"2014-02-28 01:58:20"},{"id":2,"user_id":1,"active":true,"name":"Ullam eaque est voluptates.","answer_time":40,"created_at":"2014-02-28 01:58:20","updated_at":"2014-02-28 01:58:20"}],"embeds":["user","difficulties","categories"]}</pre>
                    </td>
                    <td>200</td>
                    <td>{{ $icon->done->true }}</td>
                </tr>
                </tbody>
            </table>

            <hr>
            <h4>Games</h4>
            <table class="table table-bordered table-hover">
                <thead>
                    @include('tableheaders')
                </thead>
                <tbody>
                <tr>
                    <td class="action-create">Create</td>
                    <td>POST</td>
                    <td>{{ $url_prefix }}/games</td>
                    <td>{{ $icon->auth->on }}</td>
                    <td>
                        {{ $icon->example->off }}
                        <pre class="example"></pre>
                    </td>
                    <td>
                        {{ $icon->example->off }}
                        <pre class="example"></pre>
                    </td>
                    <td>201</td>
                    <td>{{ $icon->done->false }}</td>
                </tr>
                <tr>
                    <td class="action-read">Read</td>
                    <td>GET</td>
                    <td>{{ $url_prefix }}/games/{id}</td>
                    <td>{{ $icon->auth->on }}</td>
                    <td>
                        {{ $icon->example->none }}
                        <pre class="example"></pre>
                    </td>
                    <td>
                        {{ $icon->example->on }}
                        <pre class="example">{"data":{"id":2,"user_id":1,"active":true,"name":"Ullam eaque est voluptates.","answer_time":40,"created_at":"2014-02-28 01:58:20","updated_at":"2014-02-28 01:58:20"},"embeds":["user","difficulties","categories"]}</pre>
                    </td>
                    <td>200</td>
                    <td>{{ $icon->done->true }}</td>
                </tr>
                <tr>
                    <td class="action-update">Update</td>
                    <td>POST</td>
                    <td>{{ $url_prefix }}/games/{id}</td>
                    <td>{{ $icon->auth->on }}</td>
                    <td>
                        {{ $icon->example->off }}
                        <pre class="example"></pre>
                    </td>
                    <td>
                        {{ $icon->example->off }}
                        <pre class="example"></pre>
                    </td>
                    <td>200</td>
                    <td>{{ $icon->done->false }}</td>
                </tr>
                <tr>
                    <td class="action-delete">Delete</td>
                    <td>DELETE</td>
                    <td>{{ $url_prefix }}/games/{id}</td>
                    <td>{{ $icon->auth->on }}</td>
                    <td>
                        {{ $icon->example->none }}
                        <pre class="example"></pre>
                    </td>
                    <td>
                        {{ $icon->example->none }}
                        <pre class="example"></pre>
                    </td>
                    <td>204</td>
                    <td>{{ $icon->done->false }}</td>
                </tr>
                <tr>
                    <td class="action-list">List</td>
                    <td>GET</td>
                    <td>{{ $url_prefix }}/games/{id}/catgories</td>
                    <td>{{ $icon->auth->on }}</td>
                    <td>
                        {{ $icon->example->none }}
                        <pre class="example"></pre>
                    </td>
                    <td>
                        {{ $icon->example->on }}
                        <pre class="example">{"data":[{"id":1,"game_id":1,"active":true,"order":1,"name":"Aut et.","created_at":"2014-02-28 01:58:21","updated_at":"2014-02-28 01:58:21"},{"id":2,"game_id":1,"active":false,"order":2,"name":"Qui.","created_at":"2014-02-28 01:58:21","updated_at":"2014-02-28 01:58:21"},{"id":3,"game_id":1,"active":false,"order":3,"name":"Voluptatum.","created_at":"2014-02-28 01:58:21","updated_at":"2014-02-28 01:58:21"}],"embeds":["game","questions"]}</pre>
                    </td>
                    <td>200</td>
                    <td>{{ $icon->done->true }}</td>
                </tr>
                <tr>
                    <td class="action-list">List</td>
                    <td>GET</td>
                    <td>{{ $url_prefix }}/games/{id}/difficulties</td>
                    <td>{{ $icon->auth->on }}</td>
                    <td>
                        {{ $icon->example->none }}
                        <pre class="example"></pre>
                    </td>
                    <td>
                        {{ $icon->example->on }}
                        <pre class="example">{"data":[{"id":1,"game_id":1,"order":1,"name":"Maxime.","points":100,"created_at":"2014-02-28 01:58:22","updated_at":"2014-02-28 01:58:22"},{"id":2,"game_id":1,"order":2,"name":"Vel ipsum.","points":200,"created_at":"2014-02-28 01:58:22","updated_at":"2014-02-28 01:58:22"}],"embeds":["game","questions"]}</pre>
                    </td>
                    <td>200</td>
                    <td>{{ $icon->done->true }}</td>
                </tr>
                </tbody>
            </table>


            <hr>
            <h4>Categories</h4>
            <table class="table table-bordered table-hover">
                <thead>
                    @include('tableheaders')
                </thead>
                <tbody>
                <tr>
                    <td class="action-create">Create</td>
                    <td>POST</td>
                    <td>{{ $url_prefix }}/categories</td>
                    <td>{{ $icon->auth->on }}</td>
                    <td>
                        {{ $icon->example->off }}
                        <pre class="example"></pre>
                    </td>
                    <td>
                        {{ $icon->example->off }}
                        <pre class="example"></pre>
                    </td>
                    <td>201</td>
                    <td>{{ $icon->done->false }}</td>
                </tr>
                <tr>
                    <td class="action-read">Read</td>
                    <td>GET</td>
                    <td>{{ $url_prefix }}/categories/{id}</td>
                    <td>{{ $icon->auth->on }}</td>
                    <td>
                        {{ $icon->example->none }}
                        <pre class="example"></pre>
                    </td>
                    <td>
                        {{ $icon->example->on }}
                        <pre class="example">{"data":{"id":2,"game_id":1,"active":false,"order":2,"name":"Qui.","created_at":"2014-02-28 01:58:21","updated_at":"2014-02-28 01:58:21"},"embeds":["game","questions"]}</pre>
                    </td>
                    <td>200</td>
                    <td>{{ $icon->done->true }}</td>
                </tr>
                <tr>
                    <td class="action-update">Update</td>
                    <td>POST</td>
                    <td>{{ $url_prefix }}/categories/{id}</td>
                    <td>{{ $icon->auth->on }}</td>
                    <td>
                        {{ $icon->example->off }}
                        <pre class="example"></pre>
                    </td>
                    <td>
                        {{ $icon->example->off }}
                        <pre class="example"></pre>
                    </td>
                    <td>200</td>
                    <td>{{ $icon->done->false }}</td>
                </tr>
                <tr>
                    <td class="action-delete">Delete</td>
                    <td>DELETE</td>
                    <td>{{ $url_prefix }}/categories/{id}</td>
                    <td>{{ $icon->auth->on }}</td>
                    <td>
                        {{ $icon->example->none }}
                        <pre class="example"></pre>
                    </td>
                    <td>
                        {{ $icon->example->none }}
                        <pre class="example"></pre>
                    </td>
                    <td>204</td>
                    <td>{{ $icon->done->false }}</td>
                </tr>
                <tr>
                    <td class="action-list">List</td>
                    <td>GET</td>
                    <td>{{ $url_prefix }}/categories/{id}/questions</td>
                    <td>{{ $icon->auth->on }}</td>
                    <td>
                        {{ $icon->example->none }}
                        <pre class="example"></pre>
                    </td>
                    <td>
                        {{ $icon->example->on }}
                        <pre class="example">{"data":[{"id":1,"category_id":1,"difficulty_id":1,"question":"Aut consequatur sint qui aperiam tempore quia.","answer":"Lelah Ebert","created_at":"2014-02-28 01:58:24","updated_at":"2014-02-28 01:58:24"},{"id":2,"category_id":1,"difficulty_id":2,"question":"Quibusdam possimus voluptates qui soluta eligendi qui.","answer":"Dereck Mayer","created_at":"2014-02-28 01:58:24","updated_at":"2014-02-28 01:58:24"}],"embeds":["category","difficulty"]}</pre>
                    </td>
                    <td>200</td>
                    <td>{{ $icon->done->true }}</td>
                </tr>
                </tbody>
            </table>


            <hr>
            <h4>Difficulties</h4>
            <table class="table table-bordered table-hover">
                <thead>
                    @include('tableheaders')
                </thead>
                <tbody>
                <tr>
                    <td class="action-create">Create</td>
                    <td>POST</td>
                    <td>{{ $url_prefix }}/difficulties</td>
                    <td>{{ $icon->auth->on }}</td>
                    <td>
                        {{ $icon->example->off }}
                        <pre class="example"></pre>
                    </td>
                    <td>
                        {{ $icon->example->off }}
                        <pre class="example"></pre>
                    </td>
                    <td>201</td>
                    <td>{{ $icon->done->false }}</td>
                </tr>
                <tr>
                    <td class="action-read">Read</td>
                    <td>GET</td>
                    <td>{{ $url_prefix }}/difficulties/{id}</td>
                    <td>{{ $icon->auth->on }}</td>
                    <td>
                        {{ $icon->example->none }}
                        <pre class="example"></pre>
                    </td>
                    <td>
                        {{ $icon->example->on }}
                        <pre class="example">{"data":{"id":2,"game_id":1,"order":2,"name":"Vel ipsum.","points":200,"created_at":"2014-02-28 01:58:22","updated_at":"2014-02-28 01:58:22"},"embeds":["game","questions"]}</pre>
                    </td>
                    <td>200</td>
                    <td>{{ $icon->done->true }}</td>
                </tr>
                <tr>
                    <td class="action-update">Update</td>
                    <td>POST</td>
                    <td>{{ $url_prefix }}/difficulties/{id}</td>
                    <td>{{ $icon->auth->on }}</td>
                    <td>
                        {{ $icon->example->off }}
                        <pre class="example"></pre>
                    </td>
                    <td>
                        {{ $icon->example->off }}
                        <pre class="example"></pre>
                    </td>
                    <td>200</td>
                    <td>{{ $icon->done->false }}</td>
                </tr>
                <tr>
                    <td class="action-delete">Delete</td>
                    <td>DELETE</td>
                    <td>{{ $url_prefix }}/difficulties/{id}</td>
                    <td>{{ $icon->auth->on }}</td>
                    <td>
                        {{ $icon->example->none }}
                        <pre class="example"></pre>
                    </td>
                    <td>
                        {{ $icon->example->none }}
                        <pre class="example"></pre>
                    </td>
                    <td>204</td>
                    <td>{{ $icon->done->false }}</td>
                </tr>
                </tbody>
            </table>


            <hr>
            <h4>Questions</h4>
            <table class="table table-bordered table-hover">
                <thead>
                    @include('tableheaders')
                </thead>
                <tbody>
                <tr>
                    <td class="action-create">Create</td>
                    <td>POST</td>
                    <td>{{ $url_prefix }}/questions</td>
                    <td>{{ $icon->auth->on }}</td>
                    <td>
                        {{ $icon->example->off }}
                        <pre class="example"></pre>
                    </td>
                    <td>
                        {{ $icon->example->off }}
                        <pre class="example"></pre>
                    </td>
                    <td>201</td>
                    <td>{{ $icon->done->false }}</td>
                </tr>
                <tr>
                    <td class="action-read">Read</td>
                    <td>GET</td>
                    <td>{{ $url_prefix }}/questions/{id}</td>
                    <td>{{ $icon->auth->on }}</td>
                    <td>
                        {{ $icon->example->none }}
                        <pre class="example"></pre>
                    </td>
                    <td>
                        {{ $icon->example->on }}
                        <pre class="example">{"data":{"id":2,"category_id":1,"difficulty_id":2,"question":"Quibusdam possimus voluptates qui soluta eligendi qui.","answer":"Dereck Mayer","created_at":"2014-02-28 01:58:24","updated_at":"2014-02-28 01:58:24"},"embeds":["category","difficulty"]}</pre>
                    </td>
                    <td>200</td>
                    <td>{{ $icon->done->true }}</td>
                </tr>
                <tr>
                    <td class="action-update">Update</td>
                    <td>POST</td>
                    <td>{{ $url_prefix }}/questions/{id}</td>
                    <td>{{ $icon->auth->on }}</td>
                    <td>
                        {{ $icon->example->off }}
                        <pre class="example"></pre>
                    </td>
                    <td>
                        {{ $icon->example->off }}
                        <pre class="example"></pre>
                    </td>
                    <td>200</td>
                    <td>{{ $icon->done->false }}</td>
                </tr>
                <tr>
                    <td class="action-delete">Delete</td>
                    <td>DELETE</td>
                    <td>{{ $url_prefix }}/questions/{id}</td>
                    <td>{{ $icon->auth->on }}</td>
                    <td>
                        {{ $icon->example->none }}
                        <pre class="example"></pre>
                    </td>
                    <td>
                        {{ $icon->example->none }}
                        <pre class="example"></pre>
                    </td>
                    <td>204</td>
                    <td>{{ $icon->done->false }}</td>
                </tr>
                </tbody>
            </table>






        </div>
    </div>

@stop
