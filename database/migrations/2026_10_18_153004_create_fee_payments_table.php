   <?php
   use Illuminate\Database\Migrations\Migration;
   use Illuminate\Database\Schema\Blueprint;
   use Illuminate\Support\Facades\Schema;

   return new class extends Migration {
       public function up(): void {
           Schema::create('fee_payments', function (Blueprint $table) {
               $table->id();
               $table->foreignId('student_id')->constrained()->onDelete('cascade');
               $table->foreignId('fee_type_id')->constrained()->onDelete('cascade');
               $table->foreignId('academic_session_id')->constrained()->onDelete('cascade');
               $table->decimal('amount_paid', 10, 2);
               $table->string('payment_method')->default('Cash'); // Cash, Mobile Money, Bank
               $table->string('reference_number')->nullable();
               $table->date('payment_date');
               $table->timestamps();
           });
       }
       public function down(): void { Schema::dropIfExists('fee_payments'); }
   };