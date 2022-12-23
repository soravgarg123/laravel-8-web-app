@php
    $website_name = session('configurations')['website_name'];
@endphp
<footer id="footer">
    Copyright © {{date('Y')}} {{$website_name}}
</footer>

<div id="modal-section"></div>

<!--  Error & Success Messages -->
<script type="text/javascript">
    $(document).ready(function(){
        @if(Session::has('error'))
            showToaster('error','Error !',"{{ Session::get('error')  }}")
        @endif
        @if(Session::has('success'))
            showToaster('success','Success !',"{{ Session::get('success')  }}")
        @endif
        @if(Session::has('login_success'))
            localStorage.setItem('login_session_key', "{{ Session::get('admin_user')['login_session_key'] }}");
            localStorage.setItem('user_guid', "{{ Session::get('admin_user')['user_guid']  }}");
            showToaster('success','Success !',"{{ Session::get('login_success')  }}")
        @endif
    });
</script>
</body>

</html>
