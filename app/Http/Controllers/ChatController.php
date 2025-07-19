<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function ask(Request $request)
    {
        try {
            $question = $request->input('question');
            
            if (!$question) {
                return response()->json(['answer' => 'Please enter a question'], 400);
            }
            
            $question = mb_strtolower($question, 'UTF-8');
            
            
            \Log::info('Chat question: ' . $question);
            
            // Welcome message
            if (mb_strpos($question, 'hello') !== false || mb_strpos($question, 'hi') !== false || mb_strpos($question, 'welcome') !== false) {
                return response()->json([
                    'answer' => 'Hello! I am the smart assistant for the real estate website. I can help you search for properties, prices, locations, and more. How can I assist you?'
                ]);
            }
            
            // Help message
            if (mb_strpos($question, 'help') !== false) {
                return response()->json([
                    'answer' => "I can help you with:\n\n🏠 Properties:\n- Search for properties\n- Get prices\n- Get locations\n- Number of available properties\n\n👥 Users:\n- Search for users\n- Get user count\n- Search for sellers\n- Search for customers\n- User names\n\n📊 Statistics:\n- System statistics\n\nTry asking me about any of these topics!"
                ]);
            }
            
            // Search for properties
            if (mb_strpos($question, 'properties') !== false) {
                try {
                    $properties = DB::table('properties')
                        ->join('addresses', 'properties.citynum', '=', 'addresses.id')
                        ->select('properties.*', 'addresses.city', 'addresses.full_address')
                        ->limit(3)
                        ->get();
                    
                    if ($properties->count() > 0) {
                        $answer = "We have " . $properties->count() . " available properties:\n";
                        foreach ($properties as $property) {
                            $location = $property->full_address ?: $property->city;
                            $answer .= "- " . ($property->name ?? 'Property') . " for " . ($property->price ?? 'N/A') . " EGP in " . $location . "\n";
                        }
                        return response()->json(['answer' => $answer]);
                    } else {
                        return response()->json(['answer' => 'No properties are currently available.']);
                    }
                } catch (\Exception $e) {
                    return response()->json(['answer' => 'Sorry, there was an error searching for properties.']);
                }
            }
            
            // Search for price
            if (mb_strpos($question, 'price') !== false) {
                try {
                    $property = DB::table('properties')
                        ->join('addresses', 'properties.citynum', '=', 'addresses.id')
                        ->select('properties.*', 'addresses.city', 'addresses.full_address')
                        ->first();
                    
                    if ($property) {
                        $location = $property->full_address ?: $property->city;
                        return response()->json([
                            'answer' => 'The price of property "' . ($property->name ?? 'Property') . '" in ' . $location . ' is: ' . ($property->price ?? 'N/A') . ' EGP'
                        ]);
                    } else {
                        return response()->json(['answer' => 'No properties are currently available.']);
                    }
                } catch (\Exception $e) {
                    return response()->json(['answer' => 'Sorry, there was an error searching for the price.']);
                }
            }
            
            // Search for location
            if (mb_strpos($question, 'location') !== false || mb_strpos($question, 'where') !== false) {
                try {
                    $property = DB::table('properties')
                        ->join('addresses', 'properties.citynum', '=', 'addresses.id')
                        ->select('properties.*', 'addresses.city', 'addresses.full_address')
                        ->first();
                    
                    if ($property) {
                        $location = $property->full_address ?: $property->city;
                        return response()->json([
                            'answer' => 'The property is located in: ' . $location
                        ]);
                    } else {
                        return response()->json(['answer' => 'No properties are currently available.']);
                    }
                } catch (\Exception $e) {
                    return response()->json(['answer' => 'Sorry, there was an error searching for the location.']);
                }
            }
            
            // Search for property count
            if (mb_strpos($question, 'how many') !== false && mb_strpos($question, 'properties') !== false) {
                try {
                    $count = DB::table('properties')->count();
                    return response()->json([
                        'answer' => 'We currently have ' . $count . ' available properties.'
                    ]);
                } catch (\Exception $e) {
                    return response()->json(['answer' => 'Sorry, there was an error getting the property count.']);
                }
            }
            
            // Search for users
            if (mb_strpos($question, 'users') !== false || mb_strpos($question, 'user') !== false) {
                try {
                    $users = DB::table('users')->limit(5)->get();
                    if ($users->count() > 0) {
                        $answer = "We have " . $users->count() . " registered users:\n";
                        foreach ($users as $user) {
                            $role = $user->role ?? 'User';
                            $answer .= "- " . ($user->name ?? 'User') . " (" . $role . ")\n";
                        }
                        return response()->json(['answer' => $answer]);
                    } else {
                        return response()->json(['answer' => 'No users are currently registered.']);
                    }
                } catch (\Exception $e) {
                    return response()->json(['answer' => 'Sorry, there was an error searching for users.']);
                }
            }
            
            // Search for user count
            if (mb_strpos($question, 'how many') !== false && mb_strpos($question, 'user') !== false) {
                try {
                    $count = DB::table('users')->count();
                    return response()->json([
                        'answer' => 'There are ' . $count . ' users registered in the system.'
                    ]);
                } catch (\Exception $e) {
                    return response()->json(['answer' => 'Sorry, there was an error getting the user count.']);
                }
            }
            
            // Search for sellers
            if (mb_strpos($question, 'seller') !== false) {
                try {
                    $sellers = DB::table('users')->where('role', 'seller')->limit(3)->get();
                    if ($sellers->count() > 0) {
                        $answer = "We have " . $sellers->count() . " registered sellers:\n";
                        foreach ($sellers as $seller) {
                            $answer .= "- " . ($seller->name ?? 'Seller') . "\n";
                        }
                        return response()->json(['answer' => $answer]);
                    } else {
                        return response()->json(['answer' => 'No sellers are currently registered.']);
                    }
                } catch (\Exception $e) {
                    return response()->json(['answer' => 'Sorry, there was an error searching for sellers.']);
                }
            }
            
            // Search for customers
            if (mb_strpos($question, 'customer') !== false || mb_strpos($question, 'buyer') !== false) {
                try {
                    $customers = DB::table('users')->where('role', 'user')->limit(3)->get();
                    if ($customers->count() > 0) {
                        $answer = "We have " . $customers->count() . " registered customers:\n";
                        foreach ($customers as $customer) {
                            $answer .= "- " . ($customer->name ?? 'Customer') . "\n";
                        }
                        return response()->json(['answer' => $answer]);
                    } else {
                        return response()->json(['answer' => 'No customers are currently registered.']);
                    }
                } catch (\Exception $e) {
                    return response()->json(['answer' => 'Sorry, there was an error searching for customers.']);
                }
            }
            
            // Search for user names
            if (mb_strpos($question, 'name') !== false && mb_strpos($question, 'user') !== false) {
                try {
                    $users = DB::table('users')->select('name', 'email', 'role')->limit(5)->get();
                    if ($users->count() > 0) {
                        $answer = "Registered user names:\n";
                        foreach ($users as $user) {
                            $answer .= "- " . ($user->name ?? 'N/A') . " (" . ($user->role ?? 'User') . ")\n";
                        }
                        return response()->json(['answer' => $answer]);
                    } else {
                        return response()->json(['answer' => 'No users are currently registered.']);
                    }
                } catch (\Exception $e) {
                    return response()->json(['answer' => 'Sorry, there was an error searching for user names.']);
                }
            }
            
            // System statistics
            if (mb_strpos($question, 'statistics') !== false) {
                try {
                    $totalUsers = DB::table('users')->count();
                    $sellers = DB::table('users')->where('role', 'seller')->count();
                    $customers = DB::table('users')->where('role', 'user')->count();
                    $properties = DB::table('properties')->count();
                    
                    $answer = "📊 System Statistics:\n\n";
                    $answer .= "👥 Total users: " . $totalUsers . "\n";
                    $answer .= "🏪 Sellers: " . $sellers . "\n";
                    $answer .= "🛒 Customers: " . $customers . "\n";
                    $answer .= "🏠 Properties: " . $properties . "\n";
                    
                    return response()->json(['answer' => $answer]);
                } catch (\Exception $e) {
                    return response()->json(['answer' => 'Sorry, there was an error fetching statistics.']);
                }
            }

            // Default answer
            return response()->json([
                'answer' => "Sorry, I didn't understand your question. Try asking about:\n\n🏠 Properties: 'property', 'price', 'location'\n👥 Users: 'users', 'sellers', 'customers'\n\nOr type 'help' to see everything I can help you with."
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'answer' => 'Sorry, a system error occurred. Please try again.'
            ], 500);
        }
    }
}