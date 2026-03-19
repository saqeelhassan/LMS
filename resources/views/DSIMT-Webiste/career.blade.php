@extends('DSIMT-Webiste.layout')

@section('content')
    <!-- Breadcrumb -->
    <section class="breadcrumb-main">
      <div class="container">
        <div class="breadcrumb-inner">
          <h2>Careers</h2>
        </div>
      </div>
      <div class="sl-overlay"></div>
    </section>

    <section class="contact-main pb-0">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="contact-form">
              <h3 class="text-center mb-4">Apply for a Job</h3>
              <p class="text-center text-body mb-4">Fill out the form below and upload your resume. We will review your application and get in touch.</p>
              @if(session('success'))
                <div class="alert alert-success text-center mb-4">{{ session('success') }}</div>
              @endif
              @if($errors->any())
                <div class="alert alert-danger mb-4">
                  <ul class="mb-0 list-unstyled small">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
              @endif
              <form method="post" action="{{ route('dsimt.career.store') }}" enctype="multipart/form-data" class="m-auto text-center">
                @csrf
                <div class="row mb-4">
                  <div class="col">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Full Name *" value="{{ old('name') }}" required maxlength="255" />
                    @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                  </div>
                </div>
                <div class="form-outline mb-4">
                  <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email *" value="{{ old('email') }}" required maxlength="255" />
                  @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                <div class="form-outline mb-4">
                  <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Phone" value="{{ old('phone') }}" maxlength="50" />
                  @error('phone')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                <div class="form-outline mb-4">
                  <input type="text" name="position" class="form-control @error('position') is-invalid @enderror" placeholder="Position you are applying for" value="{{ old('position') }}" maxlength="255" />
                  @error('position')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                <div class="form-outline mb-4">
                  <textarea name="message" class="form-control @error('message') is-invalid @enderror" placeholder="Cover letter or message (optional)" rows="4" maxlength="5000">{{ old('message') }}</textarea>
                  @error('message')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                <div class="form-outline mb-4 text-start">
                  <label for="resume" class="form-label">Resume / CV * (PDF, DOC or DOCX, max 5 MB)</label>
                  <input type="file" name="resume" id="resume" class="form-control @error('resume') is-invalid @enderror" accept=".pdf,.doc,.docx" required />
                  @error('resume')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn">Submit Application</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection
