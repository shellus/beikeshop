@extends('admin.layouts.master')

@section('content')
    <a href="{{ route('admin.products.create') }}">Create</a>

    <x-filter :url="route('admin.products.index')" />

    <table>
        @foreach ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->description->name ?? '--' }}</td>
                <td>{{ $product->variables ? '多规格' : '单规格' }}</td>
                <td>
                    <a href="{{ route('admin.products.edit', $product) }}">编辑</a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection

