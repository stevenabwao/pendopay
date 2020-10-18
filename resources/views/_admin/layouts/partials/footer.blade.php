<footer class="footer container-fluid pl-30 pr-30">
   <div class="row">
      <div class="col-sm-12">
         <p>
         	{{ Carbon\Carbon::parse(date('Y'))->format('Y') }} 
         	&copy; {{ config('app.name') }}
         </p> 
      </div>
   </div>
</footer>