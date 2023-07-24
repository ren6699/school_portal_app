@switch(Auth::user()->position->name)

    @case('生徒')
          @php
          $auth = '生徒';
          @endphp
        @break

    @case('指導員')
          @php
          $auth = '指導員';
          @endphp
        @break

    @default

    @break
@endswitch

<!-- 生徒用 -->

<x-app-layout>

@if($auth === '生徒')
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          相談フォーム 送信画面
      </h2>
  </x-slot>

  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <form class="w-full max-w-2xl mx-auto my-8 p-8 bg-pastelblue-900 rounded-md" action="#" method="POST">
      @method('POST')
      @csrf
      <label class="block uppercase tracking-wide text-gray-700 text-lg font-bold mb-4 border-b-2 border-gray-700 pb-2">
            相談フォーム
      </label>
      <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full md:w-1/2 px-3">
          <div class="mt-4">
              <label class="block uppercase tracking-wide text-gray-700 text-md font-bold mb-2" for="instructor">
                宛先
              </label>
              <select id="instructor" name="to_user_id" class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                  <option class="hidden"></option>
                  @foreach($instructors as $instructor)
                  <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
                  @endforeach
              </select>
              <x-input-error :messages="$errors->get('to_user_id')" class="mt-2" />
            </div>
        </div>
      </div>
      
      <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full px-3 mb-6 md:mb-0">
          <label class="block tracking-wide text-gray-700 text-md font-bold mb-2" for="content">
            相談内容
          </label>
          <textarea name="content" id="content" cols="30" rows="5" class="block w-full bg-gray-50 text-gray-700 border border-gray-200 rounded-lg py-3 px-4 focus:outline-none focus:bg-white focus:border-gray-500"></textarea>
          <x-input-error :messages="$errors->get('content')" class="mt-2" />
        </div>
      </div>

      <div class="flex items-center justify-between mt-4">

        <div class="flex items-center mb-4">
          <input type="hidden" value="0" name="anonymity">
          <input id="anonymity" type="checkbox" value="1" name="anonymity" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
          <label class="block tracking-wide text-gray-700 ml-2 text-md font-bold" for="anonymity">
            匿名を希望する
          </label>
        </div>

        @if (session('status') === 'consultation.created')
        <p
        x-data="{ show: true }"
        x-show="show"
        x-transition
        x-init="setTimeout(() => show = false, 2000)"
        class="text-sm text-gray-900"
        >{{ __('Posted.') }}</p>
        @endif

        <x-primary-button class="ml-4">
            {{ __('Post') }}
        </x-primary-button>

      </div>
    </form>
  </div>

  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    @foreach($consultations as $consultation)
    <div class="max-w-2xl my-8 mx-auto bg-pastelblue-900 shadow-md sm:rounded-lg">
      <p>To:{{ $consultation->user->name }}</p>
      <p>Content:{{ $consultation->content }}</p>
      <p>Date:{{ $consultation->date }}</p>
      @if($consultation->anonymity)
      <p>匿名希望</p>
      @endif
    </div>
    @endforeach
  </div>

@elseif($auth === '指導員')
  <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            相談フォーム 確認画面
        </h2>
  </x-slot>
@endif

</x-app-layout>