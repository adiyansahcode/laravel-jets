<x-guest-layout :title="__('Create your account')">
  <x-jet-authentication-card>
    <x-slot name="logo">
      <x-jet-authentication-card-logo />
    </x-slot>

    <x-alert type="success" class="mb-4 font-medium text-sm text-green-600" />
    <x-alert type="error" class="mb-4 font-medium text-sm text-red-600" />

    <x-form id="form-login" action="{{ route('register') }}" novalidate autocomplete="off">

      <div>
        <x-jet-label for="name" value="{{ __('Name') }}" />
        @php
          $borderColor = $errors->has('name')
          ? 'border-red-300 focus:border-red-300 focus:ring-red-300'
          : 'border-gray-300 focus:border-jets-300 focus:ring-jets-300';
        @endphp
        <x-input id="name" name="name" required autofocus
          class="mt-1 block w-full rounded-md shadow-sm focus:ring focus:ring-opacity-50 {{ $borderColor }}" />
        <x-error field="name" class="mt-1 font-medium text-sm text-red-600" />
      </div>

      <div class="mt-4">
        <x-jet-label for="email" value="{{ __('Email') }}" />
        @php
          $borderColor = $errors->has('email')
          ? 'border-red-300 focus:border-red-300 focus:ring-red-300'
          : 'border-gray-300 focus:border-jets-300 focus:ring-jets-300';
        @endphp
        <x-input id="email" name="email" type="email" required
          class="mt-1 block w-full rounded-md shadow-sm focus:ring focus:ring-opacity-50 {{ $borderColor }}" />
        <x-error field="email" class="mt-1 font-medium text-sm text-red-600" />
      </div>

      <div class="mt-4">
        <x-jet-label for="password" value="{{ __('Password') }}" />
        @php
          $borderColor = $errors->has('password')
          ? 'border-red-300 focus:border-red-300 focus:ring-red-300'
          : 'border-gray-300 focus:border-jets-300 focus:ring-jets-300';
        @endphp
        <x-form.password-show id="password" name="password"
          class="mt-1 block w-full rounded-md shadow-sm focus:ring focus:ring-opacity-50 {{ $borderColor }}" />
        <x-error field="password" class="mt-1 font-medium text-sm text-red-600" />
      </div>

      <div class="mt-4">
        <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
        @php
          $borderColor = $errors->has('password_confirmation')
          ? 'border-red-300 focus:border-red-300 focus:ring-red-300'
          : 'border-gray-300 focus:border-jets-300 focus:ring-jets-300';
        @endphp
        <x-form.password-show id="password_confirmation" name="password_confirmation"
          class="mt-1 block w-full rounded-md shadow-sm focus:ring focus:ring-opacity-50 {{ $borderColor }}" />
        <x-error field="password_confirmation" class="mt-1 font-medium text-sm text-red-600" />
      </div>

      @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
      <div class="mt-4">
        <x-jet-label for="terms">
          <div class="flex items-center">
            <x-checkbox name="terms" id="terms"
              class="rounded border-jets-300 text-jets-600 shadow-sm focus:ring focus:border-jets-300 focus:ring-jets-200 focus:ring-opacity-50" />

            <div class="ml-2">
              {!! __('I agree to the :terms_of_service and :privacy_policy', [
              'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'"
                class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
              'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'"
                class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
              ]) !!}
            </div>

          </div>
          <x-error field="terms" class="mt-1 font-medium text-sm text-red-600" />
        </x-jet-label>
      </div>
      @endif

      <div class="flex items-center justify-end mt-4">
        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
          {{ __('Already registered?') }}
        </a>

        <x-jet-button class="ml-4">
          {{ __('Register') }}
        </x-jet-button>
      </div>
    </x-form>
  </x-jet-authentication-card>
</x-guest-layout>
