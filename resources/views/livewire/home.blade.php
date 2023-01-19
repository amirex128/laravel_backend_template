<div>
    <div x-data="{m:@js($m)}">

        <input type="text" x-model="m.name">
        <h1 x-text="m.name"></h1>
        <button @click="$wire.set('m',m)">send server</button>
    </div>
    <h1>your count server is :{{$m['name']}}</h1>

</div>
