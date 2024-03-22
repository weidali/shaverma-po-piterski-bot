<u>Logging</u>
<blockquote><b>{{ get_class($e) }}</b>: <i>{{ $e->getMessage() }}</i>
File: <code class="bash">{{ $e->getFile() }} ({{ $e->getLine() }})</code>
</blockquote>