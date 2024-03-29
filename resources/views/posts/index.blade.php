@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12 bg-white p-6 rounded-lg">
            <form action="{{route('posts')}}" method="POST" class="mb-4">
                    @csrf

                <div class="mb-4">
                    <label for="body" class="sr-only">Body</label>

                    <textarea name="body" id="body" cols="30" rows="4"
                    class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('body')
                    border-red-500 @enderror" placeholder="Post Something!">
                    </textarea>

                        @error('body')
                        <div class="text-red-500 mt-2 text-sm">
                             {{ $message}}
                        </div>
                    @enderror

                </div>

                <div>
                    {{-- //button --}}
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded
                font-medium">Post</button>

                </div>

            </form>
            @if ($posts->count())
                @foreach ($posts as $post)
                        <div class="mb-4">
                            <a href="{{route('users.posts', $post->user)}}" class="font-bold">{{$post->user->name}}</a>
                            <span class="text-gray-600 text-sm">{{$post->created_at->diffForHumans()}}</span>

                            <p class="mb-2">{{$post->body}}</p>

                            {{-- //check if user own the post and delete --}}
                            {{-- @if ($post->ownedBy(auth->user())) --}}

                                @can('delete', $post)
                                    <form action="{{route('posts', $post)}}" method="post" class="mr-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-blue-500">Delete</button>
                                    </form>
                                @endcan

                            {{-- @endif --}}


                            {{-- //liking and unliking post --}}
                            <div class="flex items-center">

                                @auth


                                @if (!$post->likedBy(auth()->user()))


                                <form action="{{route('posts.likes',$post->id)}}" method="post" class="mr-1">
                                    @csrf
                                    <button type="submit" class="text-blue-500">like</button>
                                </form>

                                @else

                                <form action="{{route('posts.likes',$post->id)}}" method="post" class="mr-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-blue-500">unlike</button>
                                </form>
                                @endif



                                @endauth



                                <span>{{$post->likes->count()}} {{Str::plural('like',$post->likes->count())}}</span>


                            </div>
                        </div>
                @endforeach

                {{-- Paginate --}}
                {{$posts->links()}}
            @else
                <p>There are no Post</p>
            @endif
        </div>
    </div>
@endsection
