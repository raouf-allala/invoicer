<x-layouts.sidebar>
	<x-slot name="header">
		<h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
			{{ __('Create Customer') }}
		</h2>
	</x-slot>


	<div class="px-4 py-12 mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
		<div class="p-4 bg-white border border-gray-200 rounded-lg dark:bg-gray-800 sm:p-8">
			<section class="grid gap-6 2xl:grid-cols-3">
				<header>
					<h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
						{{ __('Customer Information') }}
					</h2>
					<p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
						{{ __("Enter the customer's details.") }}
					</p>
				</header>

				<div class="col-span-2">
					<form method="post" action="{{ route('customers.store') }}" enctype="multipart/form-data">
						@csrf

						<div class="space-y-6">
							<div class="grid gap-6 md:grid-cols-2">
								<!-- Name -->
								<div>
									<x-input-label for="name" :value="__('Name')" />
									<x-text-input id="name" name="name" type="text" class="block w-full mt-1"
										:value="old('name')" required autofocus autocomplete="name" />
									<x-input-error class="mt-2" :messages="$errors->get('name')" />
								</div>

								<!-- Email -->
								<div>
									<x-input-label for="email" :value="__('Email')" />
									<x-text-input id="email" name="email" type="email" class="block w-full mt-1"
										:value="old('email')" required />
									<x-input-error class="mt-2" :messages="$errors->get('email')" />
								</div>

								<!-- Phone -->
								<div>
									<x-input-label for="phone" :value="__('Phone')" />
									<x-text-input id="phone" name="phone" type="tel" class="block w-full mt-1"
										:value="old('phone')" />
									<x-input-error class="mt-2" :messages="$errors->get('phone')" />
								</div>

								<!-- RC -->
								<div>
									<x-input-label for="rc" :value="__('RC')" />
									<x-text-input id="rc" name="rc" type="text" class="block w-full mt-1"
										:value="old('rc')" />
									<x-input-error class="mt-2" :messages="$errors->get('rc')" />
								</div>

								<!-- NIF -->
								<div>
									<x-input-label for="nif" :value="__('NIF')" />
									<x-text-input id="nif" name="nif" type="text" class="block w-full mt-1"
										:value="old('nif')" />
									<x-input-error class="mt-2" :messages="$errors->get('nif')" />
								</div>

								<!-- AI -->
								<div>
									<x-input-label for="ai" :value="__('AI')" />
									<x-text-input id="ai" name="ai" type="text" class="block w-full mt-1"
										:value="old('ai')" />
									<x-input-error class="mt-2" :messages="$errors->get('ai')" />
								</div>

								<!-- NIS -->
								<div>
									<x-input-label for="nis" :value="__('NIS')" />
									<x-text-input id="nis" name="nis" type="text" class="block w-full mt-1"
										:value="old('nis')" />
									<x-input-error class="mt-2" :messages="$errors->get('nis')" />
								</div>
							</div>


							<!-- Address -->
							<div>
								<x-input-label for="address" :value="__('Address')" />
								<x-textarea id="address" name="address"
									class="block w-full mt-1">{{ old('address') }}</x-textarea>
								<x-input-error class="mt-2" :messages="$errors->get('address')" />
							</div>

							<!-- Submit Button -->
							<div class="flex items-center gap-4">
								<x-primary-button>{{ __('Create Customer') }}</x-primary-button>
							</div>
						</div>
					</form>
				</div>

			</section>
		</div>
	</div>
</x-layouts.sidebar>