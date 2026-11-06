   <?php
   use Illuminate\Database\Migrations\Migration;
   use Illuminate\Database\Schema\Blueprint;
   use Illuminate\Support\Facades\Schema;

   return new class extends Migration {
       public function up(): void {
           Schema::create('admission_applications', function (Blueprint $table) {
               $table->id();
               $table->string('first_name');
               $table->string('last_name');
               $table->string('date_of_birth');
               $table->string('gender');
               $table->string('passport_photo');
               $table->string('parent_name');
               $table->string('parent_phone');
               $table->string('parent_email')->nullable();
               $table->string('previous_school')->nullable();
               $table->string('applying_for_class');
               $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
               $table->timestamps();
           });
       }
       public function down(): void { Schema::dropIfExists('admission_applications'); }
   };