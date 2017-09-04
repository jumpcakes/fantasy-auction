<template>
 <div class="modal-mask" transition="modal" @click.stop="close">
    <div class="modal-wrapper">
      	<div class="modal-container" @click.stop>
      		<button @click.stop="close" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<slot></slot>
      	</div>
    </div>
  </div>
</template>

 <script>
	 export default {

	 	methods: {
		  
		    close: function() {
		    	Event.$emit('close');
		    }
	  	},

	}
 </script>