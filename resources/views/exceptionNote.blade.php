{{-- In Laravel 5.4 forbiddenResponse method is removed. So how can we custom the error message? We can custom the message as follow:

    Open app/Exceptions/Handler.php
    Go to render method and in this method we can check if the excpetion is AuthorizationException than we response a message.

public function render($request, Exception $exception)
{
    if ($exception instanceof \Illuminate\Auth\Access\AuthorizationException) {
        return response()->view('errors.authorization-error', [], 500);
    }
    return parent::render($request, $exception);
}

    In resources/views directory create new directory called errors 
    In resources/views/errors directory  create new file called authorization-error.blade.php and show the error message. Here the example: --}}

<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <title>Authorization Error</title>
</head>
<body>
 <h1>You cannot delete default category!</h1>
 <a href="javascript:window.history.back();">Go back</a>
</body>
</html>



{{-- So here we need to hashing the password before we save it into database. Here I'll show you two options.

#1. Hashing the password in the UsersController

public function store(Requests\UserStoreRequest $request)
{
    $data = $request->all();
    $data['password'] = bcrypt($data['password']);
    User::create($data);
    return redirect("/backend/users")->with("message", "New user was created successfully!");
}

#2. Hashing the password in User model through mutator

public function setPasswordAttribute($value)
{
    if (!empty($value)) $this->attributes['password'] = bcrypt($value);
} --}}
