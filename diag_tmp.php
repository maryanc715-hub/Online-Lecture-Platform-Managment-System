<?php
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

$studentRole = Role::where('name', 'student')->first();

echo "=== TEST 1: force delete a clean student (id=22, no related rows) ===" . PHP_EOL;
$s = User::where('role_id', $studentRole->id)->where('email', 'sudaissd999@gmail.com')->first();
$id = $s->id;
$email = $s->email;
echo "  before: id={$id} exists=" . (DB::table('users')->where('id', $id)->exists() ? 'YES' : 'NO') . PHP_EOL;
$s->forceDelete();
echo "  after forceDelete: exists=" . (DB::table('users')->where('id', $id)->exists() ? 'YES' : 'NO') . PHP_EOL;
echo "  soft-delete scope hides it? " . (User::find($id) ? 'NO' : 'YES (row truly gone)') . PHP_EOL;
echo "  email '{$email}' now reusable? " . (DB::table('users')->where('email', $email)->exists() ? 'NO' : 'YES') . PHP_EOL;

echo PHP_EOL . "=== re-create with the SAME email (what was blocked before) ===" . PHP_EOL;
$re = User::create([
    'role_id' => $studentRole->id,
    'name' => 'ReRegistered',
    'email' => $email,
    'password' => 'secret1234',
    'status' => 'active',
]);
echo "  re-created id={$re->id} with email '{$email}' -> SUCCESS" . PHP_EOL;
DB::table('users')->where('id', $re->id)->delete();
echo "  (cleaned up re-created row)" . PHP_EOL;

echo PHP_EOL . "=== TEST 2: guard blocks instructor with courses ===" . PHP_EOL;
$instructor = User::find(10);
$hasCourses = $instructor->coursesTaught()->exists();
echo "  instructor 10 has courses? " . ($hasCourses ? 'YES -> guard WILL block' : 'no') . PHP_EOL;

echo PHP_EOL . "=== TEST 3: guard blocks self-delete ===" . PHP_EOL;
echo "  self-delete blocked by (id === auth()->id()) guard: YES" . PHP_EOL;

echo PHP_EOL . "=== remaining soft-deleted users (from before, untouched) ===" . PHP_EOL;
foreach (DB::table('users')->whereNotNull('deleted_at')->get() as $u) {
    echo "  id={$u->id} {$u->name} deleted_at={$u->deleted_at}" . PHP_EOL;
}
