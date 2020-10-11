@if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>

             <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            {{ __('messages.review_errors') }}
        </div>
    @endif
    @if($errors->has('general_error'))
      <div class="alert alert-danger alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert">&times;</button>

              <strong>{{ $errors->first('general_error') }}</strong>
      </div>
    @endif
    @if(session()->has('success'))
          <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>

              {{ session()->get('success') }}
          </div>
     @endif