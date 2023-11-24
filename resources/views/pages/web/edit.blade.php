@extends('pages.layout.index');
@section('admin_content')
   <div>
       @include('pages.layout.pointer')
       <div class="mb-4">
            <h1 class="text-2xl font-bold">Candidates</h1>
            <small class="text-gray-400">Edit candidates here</small>
       </div>
        @if ($errors->any())
            <div class="text-orange">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form class="lg:w-1/2" method="POST" action="{{route('candidates.update', $candidate->id)}}">
            @method('PATCH')
            @csrf
            <div class="mb-4">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                <input type="email" id="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 focus:outline-0 block w-full p-2.5"  required value="{{ old('email') ?? $candidate->email  }}">
                @error('email')
                <small>
                    <i class="text-orange">{{ $message  }}</i>
                </small>
                @enderror
            </div>
            <div class="mb-4">
                <label for="full_name" class="block mb-2 text-sm font-medium text-gray-900">Candidates Full name</label>
                <input type="text" id="full_name" name="full_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 focus:outline-0 block w-full p-2.5"  required value="{{ old('full_name') ?? $candidate->full_name  }}">
                @error('full_name')
                    <span class="text-orange">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="phone_number" class="block mb-2 text-sm font-medium text-gray-900">Phone Number</label>
                <input type="tel" id="phone_number" name="phone_number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 focus:outline-0 block w-full p-2.5" value="{{ old('phone_number') ?? $candidate->phone_number  }}">
                @error('phone_number')
                    <span class="text-orange">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="dob" class="block mb-2 text-sm font-medium text-gray-900">Date Of Birthday</label>
                <input type="date" id="dob" name="dob" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 focus:outline-0 block w-full p-2.5"  required value="{{ old('dob') ?? $candidate->dob  }}">
                @error('dob')
                    <span class="text-orange">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="pob" class="block mb-2 text-sm font-medium text-gray-900">Place Of Birthday</label>
                <input type="text" name="pob" id="pob" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 focus:outline-0 block w-full p-2.5"  required value="{{ old('pob') ?? $candidate->pob  }}">
                @error('pob')
                    <span class="text-orange">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="gender" class="block mb-2 text-sm font-medium text-gray-900">Gender</label>
                <div>
                    <label for="f" class="inline-flex items-center mr-4">
                        <input type="radio" id="f" name="gender" class="form-radio h-5 w-5 text-orange-600" required value="f"  {{ (old('gender') === 'f' ? 'checked' : '') ?: ($candidate->gender === 'f' ? 'checked' : '') }}>
                        <span class="ml-2">Female</span>
                    </label>
                    <label for="m" class="inline-flex items-center">
                        <input type="radio" id="m" name="gender" class="form-radio h-5 w-5 text-orange-600" required value="m"  {{ (old('gender') === 'm' ? 'checked' : '') ?: ($candidate->gender === 'm' ? 'checked' : '') }}>
                        <span class="ml-2">Male</span>
                    </label>
                </div>
                @error('gender')
                    <span class="text-orange">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="year_exp" class="block mb-2 text-sm font-medium text-gray-900">Year Experience</label>
                <input type="number" max='100' min="0" name="year_exp" id="year_exp" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 focus:outline-0 block w-full p-2.5"  required value="{{ old('year_exp') ?? $candidate->year_exp  }}">
                @error('year_exp')
                    <span class="text-orange">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="last_salary" class="block mb-2 text-sm font-medium text-gray-900">Last Salary</label>
                <input type="tel" id="last_salary" name="last_salary" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 focus:outline-0 block w-full p-2.5" value="{{ old('last_salary') ?? $candidate->last_salary  }}">
                @error('last_salary')
                    <span class="text-orange">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                + Add
            </button>

        </form>

    </div>
   </div>
   @section('custom_js')
    <script>
        number_only('year_exp');
        number_only('phone_number');
        ribuan('last_salary');
    </script>
    @endsection()
@endSection()
